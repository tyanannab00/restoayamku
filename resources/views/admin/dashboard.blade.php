@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    .admin-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        border: none;
    }
    .admin-card-header {
        background-color: #343a40;
        color: white;
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-completed {
        background-color: #28a745;
        color: white;
    }
    .action-btn {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
    }
    .admin-card {
        transition: transform 0.3s ease;
    }
    .admin-card:hover {
        transform: translateY(-3px);
    }
    .action-btn:hover {
        opacity: 0.8;
        transform: scale(1.1);
    }
    @media (max-width: 768px) {
        .admin-container { padding: 10px; }
        .table th, .table td { padding: 8px 5px; font-size: 0.9rem; }
        .action-btn { width: 25px; height: 25px; font-size: 0.8rem; }
    }
    .table th { background-color: #343a40; color: white; }
    .img-thumbnail { max-height: 60px; object-fit: cover; }
    .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="container-fluid">
        <!-- Daftar Pesanan -->
        <div class="table-responsive mb-4">
            <h3 class="mb-3">Daftar Pesanan</h3>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            @if($order->product)
                                {{ $order->product->name }}
                                @if($order->product->trashed())
                                    <span class="badge bg-danger">(Dihapus)</span>
                                @endif
                            @else
                                <span class="text-danger">Produk Dihapus</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesanan ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Manajemen Produk -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Daftar Produk</h3>
                <a href="{{ route('products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Harga Diskon</th>
                        <th>Kategori</th>
                        <th>Waktu Persiapan (menit)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="60" class="img-thumbnail">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->discounted_price ? 'Rp '.number_format($product->discounted_price, 0, ',', '.') : '-' }}</td>
                        <td>{{ $product->category ?? '-' }}</td>
                        <td>{{ $product->preparation_time ?? '-' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada produk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
