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

    /* Compact, tidy table styles */
    .table.table-compact td, .table.table-compact th { padding: 0.5rem 0.75rem; }
    .table.table-compact tbody tr { background: #fff; }
    .table.table-compact .text-truncate { max-width: 180px; display: inline-block; }
    .table .align-middle { vertical-align: middle !important; }

    /* Placeholder image box when product image is missing */
    .img-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg,#ececec 25%,#f8f8f8 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    /* small improvements to action column */
    .actions-group .btn { margin-right: 6px; }

    /* Card improvements */
    .admin-card { overflow: visible; }
    .admin-card .card-body { background: transparent; }
    .card-header .badge-count { font-size: 0.9rem; }

    /* nicer empty state */
    .empty-illustration { width: 120px; height: 80px; opacity: 0.7; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="container-fluid">
        <!-- Daftar Pesanan -->
        <div class="card admin-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center admin-card-header">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 text-black">Daftar Pesanan</h5>
                    <span class="badge bg-light text-dark badge-count">{{ $orders->count() }}</span>
                </div>
                <div>
                    <!-- quick filter placeholder -->
                    <form class="d-flex" method="GET">
                        <input type="search" name="order_q" class="form-control form-control-sm" placeholder="Cari pesanan..." value="{{ request('order_q') }}" style="min-width:200px">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm align-middle">
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
                                <td class="text-muted">#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    @if($order->product)
                                        <div class="text-truncate" style="max-width:260px" title="{{ $order->product->name }}">{{ $order->product->name }}</div>
                                        @if(method_exists($order->product, 'trashed') && $order->product->trashed())
                                            <span class="badge bg-danger">Dihapus</span>
                                        @endif
                                    @else
                                        <span class="text-danger">Produk Dihapus</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus pesanan ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <svg class="empty-illustration" viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <rect width="120" height="80" rx="8" fill="#f1f3f5" />
                                        </svg>
                                        <div class="mt-2 text-muted">Belum ada pesanan</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Manajemen Produk -->
        <!-- <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Daftar Produk</h3>
                <div class="d-flex gap-2 align-items-center">
                    <form action="" method="GET" class="d-flex">
                        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari produk..." style="min-width:200px">
                    </form>
                    <a href="{{ route('products.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>
        </div> -->

        <div class="card admin-card">
            <div class="card-header d-flex justify-content-between align-items-center admin-card-header">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 text-black">Daftar Produk</h5>
                    <span class="badge bg-light text-dark badge-count">{{ $products->count() }}</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <form action="" method="GET" class="d-flex">
                        <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari produk..." style="min-width:200px">
                    </form>
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm align-middle">
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
                                    @if(!empty($product->image_path))
                                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" width="60" class="img-thumbnail rounded">
                                    @else
                                        <div class="img-placeholder" title="Tidak ada gambar">No Img</div>
                                    @endif
                                </td>
                                <td><div class="text-truncate" title="{{ $product->name }}">{{ $product->name }}</div></td>
                                <td class="text-nowrap">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-nowrap">
                                    @if(!empty($product->discounted_price))
                                        Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $product->category ?? '' }}@if(empty($product->category))<span class="text-muted">-</span>@endif</td>
                                <td>
                                    @if(!empty($product->preparation_time))
                                        {{ $product->preparation_time }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions-group">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus produk ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <svg class="empty-illustration" viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <rect width="120" height="80" rx="8" fill="#f1f3f5" />
                                        </svg>
                                        <div class="mt-2 text-muted">Tidak ada produk</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
