@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card admin-card">
        <div class="card-header admin-card-header">
            <h4><i class="fas fa-plus-circle"></i> Tambah Produk Baru</h4>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Diskon (Opsional)</label>
                    <input type="number" name="discounted_price" class="form-control" placeholder="dalam rupiah">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori (Opsional)</label>
                    <input type="text" name="category" class="form-control" placeholder="">
                </div>

                <div class="mb-3">
                    <label class="form-label">Waktu Persiapan (menit, Opsional)</label>
                    <input type="number" name="preparation_time" class="form-control" placeholder="">
                </div>

                <div class="mb-3">
                    <label>Deskripsi Produk</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
