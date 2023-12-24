@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .container {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        #tratamientosTable_wrapper {
            margin-top: 20px;
        }

        .add-btn-container {
            margin-bottom: 20px;
        }

        #tratamientosTable th,
        #tratamientosTable td {
            text-align: center;
        }

        #tratamientosTable thead {
            background-color: rgb(225, 225, 225);

        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Tratamientos</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mensajes de sesión -->
                        @if (session('success'))
                            <script>
                                Toastify({
                                    text: '{{ session('success') }}',
                                    duration: 2000,
                                    close: true,
                                    gravity: 'top',
                                    positionLeft: false,
                                    backgroundColor: 'green',
                                    className: 'success',
                                }).showToast();
                            </script>
                        @elseif(session('error'))
                            <script>
                                Toastify({
                                    text: '{{ session('error') }}',
                                    duration: 2000,
                                    close: true,
                                    gravity: 'top',
                                    positionLeft: false,
                                    backgroundColor: 'red',
                                    className: 'error',
                                }).showToast();
                            </script>
                        @endif
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#crearTratamientoModal">
                            Agregar Tratamiento
                        </button>
                        <table id="tratamientosTable" class="table table-hover table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Tratamiento</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tratamientos as $tratamiento)
                                    <tr>
                                        <td>{{ $tratamiento->nombreTratamiento }}</td>
                                        <td>{{ $tratamiento->descripcion }}</td>
                                        <td>{{ $tratamiento->precio }}</td>
                                        <td>
                                            {{ $tratamiento->estado === 'a' ? 'Activo' : ($tratamiento->estado === 'i' ? 'Inactivo' : $tratamiento->estado) }}
                                        </td>
                                        <td>
                                            @if ($tratamiento->nombreImagen)
                                                <img src="{{ asset('img/tratamientos/' . $tratamiento->nombreImagen) }}"
                                                    alt="Imagen del Tratamiento"
                                                    style="max-width: 100px; max-height: 100px;">
                                            @else
                                                Sin imagen
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#editarTratamientoModal{{ $tratamiento->id }}">
                                                Editar
                                            </button>
                                            <form action="{{ route('tratamientos.destroy', $tratamiento->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                            </form>




                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar tratamiento -->
        <div class="modal fade" id="crearTratamientoModal" tabindex="-1" role="dialog"
            aria-labelledby="crearTratamientoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearDoctorModalLabel">Agregar Tratamiento</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('tratamientos.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombreTratamiento" class="form-label">Nombre del Tratamiento</label>
                                        <input type="text" class="form-control" id="nombreTratamiento"
                                            name="nombreTratamiento" value="{{ old('nombreTratamiento') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" rows="1" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen"
                                    onchange="mostrarImagen()">
                                <img id="imagen-preview" src="#" alt="Vista previa de la imagen"
                                    style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="precio" class="form-label">Precio</label>
                                        <input type="number" class="form-control" id="precio" name="precio"
                                            value="{{ old('precio') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option value="a">Activo</option>
                                            <option value="i">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Crear Tratamiento</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($tratamientos as $tratamiento)
            <!-- Modal para editar tratamiento -->
            <div class="modal fade" id="editarTratamientoModal{{ $tratamiento->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editarTratamientoModalLabel{{ $tratamiento->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarTratamientoModalLabel">Editar
                                Tratamiento</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('tratamientos.update', $tratamiento->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombreTratamientoEditar" class="form-label">Nombre del
                                                Tratamiento</label>
                                            <input type="text" class="form-control" id="nombreTratamientoEditar"
                                                name="nombreTratamiento" value="{{ $tratamiento->nombreTratamiento }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="descripcionEditar" class="form-label">Descripción</label>
                                            <textarea class="form-control" id="descripcionEditar" name="descripcion" rows="3">{{ $tratamiento->descripcion }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="imagenEditar" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" id="imagenEditar" name="imagen"
                                        onchange="mostrarImagenEditar()">
                                    <img id="imagen-preview-editar"
                                        src="{{ asset('img/tratamientos/' . $tratamiento->nombreImagen) }}"
                                        alt="Vista previa de la imagen"
                                        style="max-width: 100%; max-height: 200px; margin-top: 10px;">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="precioEditar" class="form-label">Precio</label>
                                            <input type="number" class="form-control" id="precioEditar" name="precio"
                                                value="{{ $tratamiento->precio }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estadoEditar" class="form-label">Estado</label>
                                            <select class="form-control" id="estadoEditar" name="estado">
                                                <option value="a"
                                                    {{ $tratamiento->estado == 'a' ? 'selected' : '' }}>
                                                    Activo</option>
                                                <option value="i"
                                                    {{ $tratamiento->estado == 'i' ? 'selected' : '' }}>
                                                    Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Actualizar
                                        Tratamiento</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.js">
    </script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tratamientosTable').DataTable({
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente",
                    }
                }
            });
        });
    </script>
    <script>
        function mostrarImagen() {
            var input = document.getElementById('imagen');
            var preview = document.getElementById('imagen-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        function mostrarImagenEditar() {
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
                var tratamientoNombreImagen = @json($tratamiento->nombreImagen ?? null);

                if (tratamientoNombreImagen) {
                    // Si $tratamiento->nombreImagen está definido, usarlo
                    preview.src = "{{ asset('img/tratamientos/') }}" + '/' + tratamientoNombreImagen;
                } else {
                    // Si no hay tratamiento definido, manejar la situación de alguna manera
                    console.log("No hay tratamiento definido.");
                }
            }
        }
    </script>
@endsection
