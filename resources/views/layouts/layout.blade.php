<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apotek Sejahtera Abadi</title>
    <link rel="icon" href="{{ asset('assets/images/logo1.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @stack('style')
    <style>
        /* Latar belakang navbar dengan gradasi warna */
        .navbar {
            background: linear-gradient(45deg, #0066ff, #00cc99);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Efek hover pada link navbar */
        .navbar-nav .nav-link {
            color: #ffffff;
            font-weight: bold;
            transition: color 0.3s, transform 0.2s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffcc00;
            transform: scale(1.1);
        }

        /* Tombol search yang menarik dengan efek pencahayaan */
        .btn-outline-success {
            color: #ffffff;
            border-color: #ffffff;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-outline-success:hover {
            background-color: #00cc99;
            border-color: #00cc99;
            box-shadow: 0 0 10px #00cc99, 0 0 20px #00cc99;
        }

        /* Efek dropdown dengan animasi */
        .dropdown-menu {
            animation: fadeIn 0.5s ease-in-out;
            border-radius: 10px;
            background-color: #0066ff;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling ikon */
        .navbar-brand i {
            color: #ffcc00;
            font-size: 1.5rem;
            margin-right: 8px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-house-fill"></i> Apotek</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if (Auth::check())
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('landing_page') ? 'text-warning' : '' }}"
                                href="/landing">Home</a>
                        </li>
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Route::is('obat.data') || Route::is('obat.tambah.formulir') ? 'text-warning' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Obat
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('obat.data') }}">Data Obat</a></li>
                                    <li><a class="dropdown-item" href="{{ route('obat.tambah') }}">Tambah</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Route::is('kelola.data') || Route::is('kelola.tambah.formulir') ? 'text-warning' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Kelola Akun
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('kelola.akun') }}">Kelola Akun</a></li>
                                    <li><a class="dropdown-item" href="{{ route('kelola.tambah') }}">Tambah</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <li><a class="nav-link" href="{{ route('pembelian.admin') }}">DataPembelian</a></li>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pembelian.order') }}">Pembelian</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('logout') ? 'text-warning' : '' }}"
                                href="/logout">Logout</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" action="{{ route('obat.data') }}" method="GET">
                        <input type="text" class="form-control me-2" placeholder="Search Data Obat"
                            aria-label="Search" name="search_obat">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            @endif
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @stack('script')
</body>

</html>
