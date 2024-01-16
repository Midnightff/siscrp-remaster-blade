@extends('layouts.index')


@section('content')

    <head>
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
    </head>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Nuevo Paciente</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store-cliente') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres"
                                            value="{{ old('nombres') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                                            value="{{ old('apellidos') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="col-md-12">
                                    <label for="sexo" class="form-label-label">G&eacute;nero</label> <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sexo" id="sexo"
                                            value="m">
                                        <label class="form-check-label" for="sexo">Masculino</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="sexo" id="sexo"
                                            value="f">
                                        <label class="form-check-label" for="sexo">Femenino</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="numeroTelefonico" class="form-label">Tel&eacute;fono</label>
                                        <input type="text" class="form-control" id="numeroTelefonico"
                                            name="numeroTelefonico" value="{{ old('numeroTelefonico') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" name="fechaNacimiento"
                                            id="fechaNacimiento">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Verificar si la página ha sido recargada
        if (!sessionStorage.getItem('pageReloaded')) {
            // Establecer la marca de página recargada en sessionStorage
            sessionStorage.setItem('pageReloaded', 'true');

            // Recargar la página después de un breve retraso (por ejemplo, 500 ms o 0.5 segundos)
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    </script>
@endsection
