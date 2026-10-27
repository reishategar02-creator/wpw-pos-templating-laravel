<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Events\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard');
    }

    public function search(Request $request)
    {
        $keyword = trim((string) $request->query('q'));

        if ($keyword === '') {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
                if (is_numeric($keyword)) {
                    $query->orWhere('id', (int) $keyword);
                }
            })
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'price', 'stock']);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'       => 'nullable|string|max:255',
            'payment_method'      => 'required|string|in:tunai,qris,debit,ewallet',
            'discount_percent'    => 'nullable|numeric|min:0|max:100',
            'discount_amount'     => 'nullable|numeric|min:0',
            'tax'                 => 'nullable|numeric|min:0',
            'other_fee'           => 'nullable|numeric|min:0',
            'paid_amount'         => 'required|numeric|min:0',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|integer|exists:products,id',
            'items.*.qty'         => 'required|integer|min:1',
        ]);

        try {
            $transaction = DB::transaction(function () use ($validated) {
                $subtotal = 0;
                $details  = [];

                foreach ($validated['items'] as $row) {
                    $product = Product::where('id', $row['product_id'])
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($product->stock < $row['qty']) {
                        abort(422, "Stok {$product->name} tidak mencukupi.");
                    }

                    $lineSubtotal = (float) $product->price * $row['qty'];
                    $subtotal    += $lineSubtotal;

                    $details[] = [
                        'product_id'   => $product->id,
                        'product_name' => $product->name,
                        'price'        => $product->price,
                        'qty'          => $row['qty'],
                        'subtotal'     => $lineSubtotal,
                    ];

                    $product->decrement('stock', $row['qty']);
                }

                $discountPercent = $validated['discount_percent'] ?? 0;
                $discountAmount  = $validated['discount_amount'] ?? 0;
                $tax             = $validated['tax'] ?? 0;
                $otherFee        = $validated['other_fee'] ?? 0;

                $discount   = ($subtotal * $discountPercent / 100) + $discountAmount;
                $grandTotal = max(0, $subtotal - $discount + $tax + $otherFee);

                if ($validated['paid_amount'] < $grandTotal) {
                    abort(422, 'Uang pembayaran kurang dari total akhir.');
                }

                $transaction = Transaction::create([
                    'transaction_number' => $this->generateTransactionNumber(),
                    'user_id'            => auth()->id(),
                    'customer_name'      => $validated['customer_name'] ?? null,
                    'subtotal'           => $subtotal,
                    'discount'           => $discount,
                    'tax'                => $tax,
                    'other_fee'          => $otherFee,
                    'grand_total'        => $grandTotal,
                    'paid_amount'        => $validated['paid_amount'],
                    'change_amount'      => $validated['paid_amount'] - $grandTotal,
                    'payment_method'     => $validated['payment_method'],
                    'status'             => 'selesai',
                ]);

                foreach ($details as $detail) {
                    $transaction->details()->create($detail);
                }

                return $transaction;
            });
        } catch (HttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal diproses.',
            ], 500);
        }

        $order = $transaction;
        event(new OrderPlaced($order, auth()->user()));

        return response()->json([
            'success'  => true,
            'redirect' => route('kasir.transaksi.struk', $transaction),
        ]);
    }

    public function struk(Transaction $transaction)
    {
        $transaction->load('details', 'user');

        return view('kasir.struk', compact('transaction'));
    }

    private function generateTransactionNumber(): string
    {
        $prefix = 'TRX-' . now()->format('Ymd') . '-';

        $last = Transaction::where('transaction_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('transaction_number');

        $sequence = $last ? ((int) substr($last, -3)) + 1 : 1;

        return $prefix . str_pad((string) $sequence, 3, '0', STR_PAD_LEFT);
    }
}