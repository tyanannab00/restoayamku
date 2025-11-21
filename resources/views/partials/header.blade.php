<!-- Header Section -->
<header class="header-wrap">
    
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navigation-wrap">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Yongkru Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('admin.login') }}" class="btn btn-warning btn-sm ms-2">
                            <i class="fas fa-lock"></i> Are you part of us?
                        </a>
                    </li>

                    
                @auth
                    <li class="nav-item ms-lg-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger">
                                Logout <i class="fas fa-sign-out-alt ms-2"></i>
                            </button>
                        </form>
                    </li>
                @endauth

                
                @guest
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Login <i class="fas fa-sign-in-alt ms-2"></i>
                        </a>
                    </li>
                @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>