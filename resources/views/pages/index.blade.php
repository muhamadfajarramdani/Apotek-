@extends('layouts.layout')

@section('content')
    <style>
        body,
        html {
            overflow-x: hidden;
            /* Ini akan menghilangkan slider horizontal di seluruh halaman */
        }

        .hero-section {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #6c63ff 0%, #48aaff 100%);
            color: white;
            padding: 50px 0;
            position: relative;
            overflow: hidden;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
        }

        .hero-section::before,
        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-section::before {
            top: -50px;
            right: -50px;
        }

        .hero-section::after {
            bottom: -50px;
            left: -50px;
        }

        .hero-text {
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: slideInLeft 1s ease-out;
        }

        .hero-text p {
            font-size: 1.5rem;
            color: #ecf0f1;
            margin-bottom: 30px;
            animation: fadeInUp 1.5s ease-out;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideInRight 1s ease-out;
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @if (Session::get('failed'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
            style="background: linear-gradient(135deg, #ff6b6b, #f87171); border-left: 4px solid #ff4d4d; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); color: white;">
            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.5rem;"></i>
            <div>
                {{ Session::get('failed') }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"
                style="color: white;"></button>
        </div>
    @endif



    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 hero-text">
                    <h1>Selamat Datang {{ Auth::user()->name }}</h1>
                    <p>Kami menyediakan berbagai macam obat yang Anda butuhkan dengan pelayanan terbaik
                        dari apoteker profesional.</p>
                    <a href="#" class="btn btn-primary">Lihat Produk</a>
                </div>
                <div class="col-md-6 hero-image">
                    <img src="{{ asset('assets/images/fotoApoteker.png') }}" alt="Foto Apoteker">
                </div>
            </div>
        </div>
    </section>
@endsection
