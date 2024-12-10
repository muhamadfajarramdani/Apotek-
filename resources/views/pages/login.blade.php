@extends('layouts.layout')

@section('content')
    <style>
        /* Warna latar belakang abu-abu lembut */
        body {
            background-color: #e9ecef;
        }

        /* Kartu login dengan efek animasi fade-in */
        .card {
            background-color: #f8f9fa;
            animation: fadeIn 1s ease-in-out;
            border: none;
            border-radius: 15px;
        }

        /* Animasi fade-in */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input form dengan ikon */
        .input-group-text {
            background-color: #e1e8ed;
            border: none;
            border-top-left-radius: 50px;
            border-bottom-left-radius: 50px;
        }

        .form-control {
            transition: box-shadow 0.3s, transform 0.3s;
            background-color: #e1e8ed;
            border: none;
            border-top-right-radius: 50px;
            border-bottom-right-radius: 50px;
        }

        .form-control:focus {
            box-shadow: 0px 0px 8px 0px rgba(0, 123, 255, 0.4);
            transform: scale(1.05);
        }

        /* Warna dan efek hover pada tombol */
        .btn-primary {
            background-color: #007bff;
            transition: background-color 0.3s, transform 0.2s;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-primary:active {
            background-color: #004494;
            transform: translateY(1px);
        }

        /* Gaya teks */
        .text-primary {
            color: #0056b3;
        }

        .text-muted {
            color: #6c757d;
        }

        /* Warna alert */
        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
            border: none;
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-5" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <h2 class="text-primary fw-bold">Welcome Bro!</h2>
                <p class="text-muted">Log in to continue</p>
            </div>
            @if (Session::get('failed'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ Session::get('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" class="form-control shadow-sm" id="email" name="email"
                               value="{{ old('email') }}" placeholder="Enter your email">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control shadow-sm" id="password" name="password"
                               placeholder="Enter your password">
                    </div>
                </div>
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
