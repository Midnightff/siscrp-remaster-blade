@extends('layouts.navbarlog')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/arteDentalLogo.jpg') }}" width="48" class="logoart" alt="Logo">
                        </div>

                        {{-- LOGIN --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3 input-group">
                                <span class="input-group-text bg-info">
                                    <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                                </span>
                                <input id="email" type="email" placeholder="Email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 input-group">
                                <span class="input-group-text bg-info">
                                    <i class="bi bi-key-fill" style="font-size: 1.5rem;"></i>
                                </span>
                                <input id="password" type="password" placeholder="Contraseña"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-info fw-bold">
                                    {{ __('Iniciar Sesión') }}
                                </button>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col text-end">
                                <a class="btn btn-light text-dark" href="{{ route('register') }}">Aún no tengo una cuenta!</a>
                            </div>
                            <div class="col text-start">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-light text-dark" href="{{ route('password.request') }}">
                                        {{ __('Olvidé mi Contraseña') }}
                                    </a>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Terms and Conditions -->
    <!-- Your modal code here... -->

    <!-- Modal for Privacy Policy -->
    <!-- Your modal code here... -->
@endsection
