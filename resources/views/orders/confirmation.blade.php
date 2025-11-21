@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="confirmation-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
                    <h1 class="mb-3">Pesanan Berhasil!</h1>
                    <p class="lead">Terima kasih telah memesan di Yongkru</p>
                </div>

                <!-- Order Card -->
                <div class="card shadow-sm mb-5">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Product Info -->
                            <div class="col-md-4 text-center">
                            @if($order->product && $order->product->image_path)
                                <img src="{{ asset($order->product->image_path) }}" class="img-fluid">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" class="img-fluid" alt="Produk Tidak Tersedia">
                            @endif
                            </div>
                                     <!-- class="img-fluid rounded mb-3" -->
                                     <!-- alt="{{ $order->product->name }}"> -->
                                <h5>{{ $order->product->name }}</h5>
                                <p class="text-muted small">{{ $order->quantity }}x</p>
                            </div>

                            <!-- Order Details -->
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>No. Order</span>
                                        <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Pembayaran</span>
                                        <strong class="text-danger">
                                            @if($order->total_price)
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            @else
                                                (Belum dihitung)
                                            @endif
                                        </strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Estimasi Selesai</span>
                                        <strong>{{ $order->created_at->addMinutes($order->product->preparation_time)->format('H:i') }}</strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Status</span>
                                        <span class="badge bg-primary">{{ $order->status_label }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Detail Customer</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                                <p><strong>No. HP:</strong> {{ $order->formatted_phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Alamat:</strong></p>
                                <p class="text-muted">{{ $order->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    <a href="{{ route('menu.index') }}" class="btn btn-primary py-3">
                        <i class="fas fa-utensils me-2"></i> Pesan Lagi
                    </a>
                    <a href="#" class="btn btn-outline-secondary py-3">
                        <i class="fas fa-map-marker-alt me-2"></i> Lacak Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection