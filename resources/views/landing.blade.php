<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')
    <title>Vascomm Parfums</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/images/logos/Vascomm.png') }}" alt="Logo" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
            <div class="ml-auto">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <h5 class="nav-link mb-0">{{ Auth::user()->name }}</h5>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-primary mx-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('registerPage') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Carousel --}}
    <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('assets/images/carousel/Carousel.png') }}" class="d-block w-100" alt="crousel">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('assets/images/carousel/Carousel.png') }}" class="d-block w-100" alt="crousel1">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('assets/images/carousel/Carousel.png') }}" class="d-block w-100" alt="crousel2">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    {{-- Product --}}
    <div class="container mt-4">
        <h2 class="mb-4">Product Terbaru</h2>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="row">
                            @foreach ($data->new_product_desc as $item)
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ asset('product_images/' . $item->img_url) }}" class="card-img-top" alt="{{ $item->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <p class="card-text">Rp {{ number_format($item->price) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row">
                            <div class="row">
                                @foreach ($data->new_product_asc as $item)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="{{ asset('product_images/' . $item->img_url) }}" class="card-img-top" alt="{{ $item->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->name }}</h5>
                                            <p class="card-text">Rp {{ number_format($item->price) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon text-dark" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    {{-- product all --}}
    <div class="container mt-4">
        <h2 class="mb-4">Product Tersedia</h2>
        <div class="row">
            <div class="row">
                @foreach ($data->all_product as $item)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('product_images/' . $item->img_url) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Rp {{ number_format($item->price) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('assets/images/logos/Vascomm.png') }}" class="img-fluid">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut commodo in vestibulum, sed dapibus tristique nullam.</p>
                </div>
                <div class="col-md-3">
                    <h5>Layanan</h5>
                    <ul class="service-list">
                        <li>BANTUAN</li>
                        <li>TANYA JAWAB</li>
                        <li>HUBUNGI KAMI</li>
                        <li>CARA BERJUALAN</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Tentang Kami</h5>
                    <ul class="about-list">
                        <li>ABOUT US</li>
                        <li>KARIR</li>
                        <li>BLOG</li>
                        <li>KEBIJAKAN PRIVASI</li>
                        <li>SYARAT DAN KETENTUAN</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Mitra</h5>
                    <ul class="mitra-list">
                        <li>SUPPLIER</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Tambahkan script Bootstrap di sini -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
