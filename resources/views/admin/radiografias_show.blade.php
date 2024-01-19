@extends('adminlte::page')

@section('title', 'Radiografia')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-body">
                        @if (count($radiografia) == 0)
                            <div class="card">
                                <div class="card-body bg-danger rounded">
                                    <h3 class="text-uppercase text-center">NO HAY RADIOGRAFIAS PARA ESTE PACIENTE</h3>
                                </div>
                            </div>
                        @else
                            <h3 class="text-center">Radiografia</h3>
                            @foreach ($radiografia as $item)
                                <br>
                                <hr>
                                <form class="form-floating border p-3 rounded shadow-sm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Radiografia</label><br>
                                            @if ($item->nombreRadiografia != 'none.png')
                                                <img id="imagen-preview-editar"
                                                    src="{{ asset('img/radiografias/' . $item->nombreRadiografia) }}"
                                                    alt="Vista previa de la imagen"
                                                    style="max-width: 100%; max-height: 200px; margin: 10px 10px;">
                                            @else
                                                <img id="imagen-preview-editar" class="float-end border rounded"
                                                    src="{{ asset('img/radiografias/none.png') }}"
                                                    alt="Vista previa de la imagen"
                                                    style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Fecha de Realizaci&oacute;n</label>
                                            <input type="text" class="form-control" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->fechaRealizada }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Paciente</label>
                                            <input type="text" class="form-control" name="paciente_id" id="paciente_id"
                                                @readonly(true) @disabled(true)
                                                value="{{ $item->paciente->nombres }}&nbsp;{{ $item->paciente->apellidos }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Tratamiento</label>
                                            <input type="text" class="form-control" name="paciente_id" id="paciente_id"
                                                @readonly(true) @disabled(true)
                                                value="{{ $item->tratamiento->nombreTratamiento }}">
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        /* function mostrarImagenEditar() {
                                                                    var input = document.getElementById('imagenEditar');
                                                                    var preview = document.getElementById('imagen-preview-editar');

                                                                    if (input.files && input.files[0]) {
                                                                        var reader = new FileReader();

                                                                        reader.onload = function(e) {
                                                                            preview.src = e.target.result;
                                                                        };

                                                                        reader.readAsDataURL(input.files[0]);
                                                                    } else {
                                                                        // Verificar si la variable $tratamiento está definida y no es nula
                                                                        var radiografiaNombreImagen = @json($item->nombreRadiografia ?? null);

                                                                        if (radiografiaNombreImagen) {
                                                                            // Si $tratamiento->nombreImagen está definido, usarlo
                                                                            preview.src = "{{ asset('img/radiografias/') }}" + '/' + radiografiaNombreImagen;
                                                                        } else {
                                                                            // Si no hay tratamiento definido, manejar la situación de alguna manera
                                                                            preview.src = "{{ asset('img/radiografias/none.png') }}";

                                                                        }
                                                                    }
                                                                }*/
    </script>
@endsection
