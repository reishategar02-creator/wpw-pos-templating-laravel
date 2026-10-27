<!DOCTYPE html>
<html>
<head>
    <title>Upload & Manipulasi Gambar</title>
</head>
<body>
    <h2>Form Upload & Resize Gambar (Acara 31)</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo" required>
        <button type="submit">Upload & Resize</button>
    </form>
</body>
</html>