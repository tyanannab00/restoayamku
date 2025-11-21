<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    
    <!-- Meta -->
    <meta name="description" content="Menu lengkap {{ config('app.name') }} - Pesan makanan favorit Anda sekarang">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@php
use Illuminate\Support\Str;
@endphp

@include('partials.header')
<body>
    <!-- Header Section -->
    
    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            Category Filters
            <div class="row mb-4">
                <div class="col-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">Semua</a>
                        @foreach(App\Models\Product::categories() as $key => $category)
                            <a href="?category={{ $key }}" class="btn btn-outline-primary">{{ $category }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="row">
                @if(session('success'))
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
                @endif
                
                <div class="col-12 mb-4">
                    <h2 class="section-title">Menu Kami</h2>
                    @if(request()->has('category'))
                        <p class="text-muted">Kategori: {{ App\Models\Product::categories()[request('category')] ?? 'Semua' }}</p>
                    @endif
                </div>
                
                @forelse($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 product-card">
                            <!-- Product Image -->
                            <div class="product-img-container">
                                <img src="{{ asset($product->image_path) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                                @if($product->discounted_price)
                                    <span class="badge bg-danger discount-badge">Diskon</span>
                                @endif
                                <span class="availability-badge {{ $product->is_available ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->getAvailabilityText() }}
                                </span>
                            </div>
                            
                            <!-- Product Body -->
                            <div class="card-body">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                
                                <!-- Price -->
                                <div class="price-wrapper mb-2">
                                    @if($product->discounted_price)
                                        <span class="current-price fw-bold text-danger">
                                            Rp {{ number_format($product->discounted_price, 0, ',', '.') }}
                                        </span>
                                        <span class="original-price text-muted"><del>
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </del></span>
                                    @else
                                        <span class="current-price fw-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Meta -->
                                <div class="product-meta d-flex justify-content-between align-items-center">
                                    <span class="prep-time text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $product->preparation_time }} menit
                                    </span>
                                    <span class="category-badge badge bg-info text-dark">
                                        {{ App\Models\Product::categories()[$product->category] ?? $product->category }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                @if($product->is_available && (!isset($product->stock) || $product->stock > 0))
                                    <a href="{{ route('orders.form', $product->id) }}" 
                                    class="btn btn-primary w-100 order-btn">
                                        <i class="fas fa-shopping-cart me-2"></i>Pesan
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            Tidak ada produk yang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>
            
        </div>
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <!-- Product Interaction -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart animation
            document.querySelectorAll('.order-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!this.href) {
                        e.preventDefault();
                        alert('Produk tidak tersedia');
                    }
                });
            });
            
            // Price display for category filter
            const categoryLinks = document.querySelectorAll('[data-category]');
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = `?category=${this.dataset.category}`;
                });
            });
        });
    </script>
</body>
</html>