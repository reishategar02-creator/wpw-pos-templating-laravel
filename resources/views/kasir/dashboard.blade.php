@extends('layouts.admin.app')

@section('title', 'Transaksi Kasir - POS')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin_assets/assets/css/kasir.css') }}">
@endpush

@section('content')
<div class="pos-header d-flex justify-content-between align-items-start mb-3">
    <div>
        <h4 class="mb-0">Toko Retail Makmur</h4>
        <small class="text-muted">Jl. Contoh No. 123, Jember</small>
    </div>
    <div class="text-end">
        <small class="text-muted d-block">Kasir: {{ auth()->user()->name }}</small>
        <small class="text-muted" id="currentDate"></small>
    </div>
</div>

<div class="row">
    {{-- LEFT --}}
    <div class="col-lg-8 mb-3">
        <div class="card mb-3">
            <div class="card-header">Tambah Barang</div>
            <div class="card-body">
                <div class="search-area position-relative">
                    <div class="input-group">
                        <input type="text" id="searchProduct" class="form-control"
                               placeholder="Cari nama atau ID barang..." autocomplete="off">
                        <button class="btn btn-primary" type="button">Cari</button>
                    </div>
                    <div class="product-results" id="productResults"></div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Pelanggan</label>
                        <input type="text" id="customerName" class="form-control" placeholder="Umum (opsional)">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Keranjang Belanja</span>
                <span id="itemCount">0 Item</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40">No</th>
                            <th>Barang</th>
                            <th width="110">Harga</th>
                            <th width="130" class="text-center">Qty</th>
                            <th width="120" class="text-end">Subtotal</th>
                            <th width="40"></th>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Keranjang masih kosong.<br>Silakan cari barang di atas.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3">
    <div class="card-header">Upload Bukti Pembayaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="file" class="form-control form-control-sm" accept="image/*,.pdf">
                <small class="text-muted d-block">JPG, PNG, PDF. Maksimal 2MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Upload Sekarang</button>
        </form>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">Ringkasan Pembayaran</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Item</span><strong id="totalQty">0</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span><strong id="subtotal">Rp 0</strong>
                </div>
                <div class="mb-2">
                    <label class="form-label mb-1">Diskon (%)</label>
                    <input type="number" id="discountPercent" class="form-control form-control-sm" value="0" min="0" max="100">
                </div>
                <div class="mb-2">
                    <label class="form-label mb-1">Diskon (Rp)</label>
                    <input type="number" id="discountAmount" class="form-control form-control-sm" value="0" min="0">
                </div>
                <div class="mb-2">
                    <label class="form-label mb-1">Pajak / PPN (Rp)</label>
                    <input type="number" id="tax" class="form-control form-control-sm" value="0" min="0">
                </div>
                <div class="mb-3">
                    <label class="form-label mb-1">Biaya Lain (Rp)</label>
                    <input type="number" id="otherFee" class="form-control form-control-sm" value="0" min="0">
                </div>

                <div class="total-box text-center p-2 rounded mb-3">
                    <div class="text-muted small">TOTAL AKHIR</div>
                    <div class="fs-4 fw-bold" id="grandTotal">Rp 0</div>
                </div>

                <label class="form-label mb-1">Uang Dibayar</label>
                <input type="number" id="payment" class="form-control mb-3" placeholder="0">

                <label class="form-label mb-1">Metode Pembayaran</label>
                <div class="payment-method d-flex flex-wrap gap-2 mb-3" id="paymentMethod">
                    <button type="button" class="btn btn-sm btn-outline-primary active" data-method="tunai">Tunai</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-method="qris">QRIS</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-method="debit">Debit</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-method="ewallet">E-Wallet</button>
                </div>

                <div class="change-box text-center p-2 rounded mb-3" id="changeBox">
                    <div class="text-muted small" id="changeLabel">KEMBALIAN</div>
                    <div class="fs-5 fw-bold" id="change">Rp 0</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger" id="btnCancel">Batal</button>
                    <button type="button" class="btn btn-success btn-lg" id="btnPay">BAYAR &amp; CETAK</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.KASIR_SEARCH_URL = "{{ route('kasir.transaksi.cari') }}";
    window.KASIR_STORE_URL  = "{{ route('kasir.transaksi.store') }}";
    window.CSRF_TOKEN       = "{{ csrf_token() }}";
</script>
<script src="{{ asset('admin_assets/assets/js/kasir.js') }}"></script>
@endpush