<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized  = config('midtrans.isSanitized');
        Config::$is3ds        = config('midtrans.is3ds');
    }

    public function checkout(Request $request)
    {
        $orderId = 'ORDER-' . time();
        $price   = 50000;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $price,
            ],
            'customer_details' => [
                'first_name' => 'John',
                'email'      => 'john@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        Order::create(['order_id' => $orderId]);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id'   => $orderId,
        ]);
    }

    public function notification(Request $request)
    {
        $notif       = new \Midtrans\Notification();
        $transaction = $notif->transaction_status;
        $order_id    = $notif->order_id;

        if ($transaction == 'settlement') {
            
        } elseif ($transaction == 'pending') {
            
        } elseif ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            
        }

        $order = Order::where('order_id', $order_id)->first();
        if ($order) {
            $order->status = $transaction;
            $order->save();
        }

        return response()->json(['message' => 'Notification handled']);
    }
}