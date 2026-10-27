@extends('layouts.admin.app')

@section('title', 'Upload & Manipulasi Gambar')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Kasir /</span> Upload & Resize Gambar
</h4>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Form Upload & Resize Gambar (Acara 31)</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="photo" class="form-label">Pilih Gambar (JPEG, PNG, JPG - Maks 2MB)</label>
                <input class="form-control" type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg" required>
                <div class="form-text">Gambar akan otomatis di-resize menjadi 300x300 piksel dan disimpan ke folder <code>public/uploads</code>.</div>
            </div>
            <button type="submit" class="btn btn-primary">Upload & Resize</button>
        </form>

        @if(session('uploaded_image'))
            <div class="mt-4">
                <h6>Hasil Gambar yang Di-upload:</h6>
                <img src="{{ asset('uploads/' . session('uploaded_image')) }}" alt="Hasil Resize" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
            </div>
        @endif
    </div>
</div>
@endsection