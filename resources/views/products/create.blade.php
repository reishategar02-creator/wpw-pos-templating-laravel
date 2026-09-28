@extends('layouts.admin.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Tambah Product</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                @include('products._form')
                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection