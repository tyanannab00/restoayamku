@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('styles')
<style>
    .edit-container {
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .form-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .img-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 10px 0;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="edit-container">
        <div class="form-header">
            <h2><i class="fas fa-edit"></i> Edit Produk</h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Diskon</label>
                <input type="number" name="discounted_price" class="form-control" value="{{ old('discounted_price', $product->discounted_price) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Persiapan (menit)</label>
                <input type="number" name="preparation_time" class="form-control" value="{{ old('preparation_time', $product->preparation_time) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Produk</label>
                <textarea name="description" class="form-control" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(this)">
                @if($product->image_path)
                    <img src="{{ asset($product->image_path) }}" class="img-preview" id="imagePreview">
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
