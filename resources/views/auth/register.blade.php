@extends('layouts.navbarlog')

@section('content')
    <div class="container mt-1 shadow-lg" style="width: 40%;">
        <div class="row">
            <div class="col rounded border p-5">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/arteDentalLogo.jpg') }}" width="48" class="logoart">
                </div>
                {{-- LOGIN --}}

                <form method="POST" action="{{ route('register') }}" class="p-3 rounded">
                    @csrf
                    <div class="mb-4">
                        <div class="col-md-12">
                            <input id="name" type="text" placeholder="Nombre"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        {{-- <label for="email" class="form-label text-md-end">Correo Electrónico</label> --}}

                        <div class="col-md-12">
                            <input id="email" type="email" placeholder="Correo Electrónico"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        {{-- <label for="password" class="form-label">Contraseña</label> --}}

                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Contraseña"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        {{-- <label for="password-confirm" class="form-label">Confirma tu
                            contraseña</label> --}}

                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control"
                                placeholder="Confirmar contraseña" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <div class="">
                            <a href="{{ route('login') }}" class="btn btn-light text-dark">Ya tengo una cuenta</a>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-light text-dark" onclick="fieldIsEmpty()">
                                Registrarme
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <script>
        const sopas = 2;

        function fieldIsEmpty() {
            var name = document.getElementById("name");
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var password - confirm = document.getElementById("password-confirm").value;

            if (name.length == 0) {
                alert("Rellene el campo name")
            } else {
                console.log("noc");
            }
        }
    </script>
@endsection
