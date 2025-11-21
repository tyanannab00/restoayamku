<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Order - {{ $product->name }} | Yongkru</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navigation-wrap bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Yongkru Logo" height="40">
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Error Message -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <h2 class="text-center mb-4">Form Order - {{ $product->name }}</h2>
        
        <div class="row align-items-center">
            <!-- Product Info -->
            <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset($product->image_path) }}" 
                     class="img-fluid rounded product-image" 
                     alt="{{ $product->name }}"
                     loading="lazy">
                
                <div class="price-display mt-3">
                    @if($product->discounted_price)
                        <h4 class="text-danger">Rp {{ number_format($product->discounted_price, 0, ',', '.') }}</h4>
                        <p class="text-muted"><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></p>
                    @else
                        <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                    @endif
                    <p class="small text-muted">Estimasi: {{ $product->preparation_time }} menit</p>
                </div>
            </div>

            <!-- Order Form -->
            <div class="col-md-6">
                <form id="order-form" action="{{ route('orders.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                               value="{{ old('customer_name') }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}" placeholder="contoh@email.com" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor HP</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                               value="{{ old('phone') }}" placeholder="0812-3456-7890" required>
                        <small class="text-muted">Contoh: 081234567890 (tanpa spasi atau tanda)</small>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               min="1" max="{{ $max_quantity ?? 20 }}" value="{{ old('quantity', 1) }}" required>
                        <small class="text-muted">Maksimal: {{ $max_quantity ?? 20 }} pcs</small>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 py-3">
                        <span id="submit-text">Konfirmasi Pesanan</span>
                        <span id="loading-spinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </form>

                <!-- Order Summary (akan diisi via JS) -->
                <div id="order-summary" class="mt-4 d-none">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ringkasan Pesanan</h5>
                            <div id="summary-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/order.js') }}"></script>

    <!-- Inline Script -->
    <script>
        document.getElementById('quantity').addEventListener('input', function() {
            const price = {{ $product->discounted_price ?? $product->price }};
            const quantity = this.value;
            document.getElementById('price-preview').innerText = 'Rp ' + (price * quantity).toLocaleString('id-ID');
        });
    </script>
</body>
</html>