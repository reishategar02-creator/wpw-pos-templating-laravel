@extends('layouts.admin.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title text-primary">Dashboard Kasir</h4>
        <p class="mb-0">Selamat datang, {{ auth()->user()->name }}</p>
    </div>
</div>
@endsection