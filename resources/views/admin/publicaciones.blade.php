@extends('adminlte::page')

@section('title','Publicaciones')
    
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Publicaciones</h3>
            <div class="col-md-12 mt-5">
                <div class="card">
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
                        <button type="button" class="btn btn-success rounded-pill" data-toggle="modal"
                            data-target="#crearPublicacionModal"><i class="bi bi-plus-circle-fill"></i>
                            Agregar
                        </button>
                        <hr>
                        <table id="publicacionesTable" class="table table-hover table-sm table-bordered text-center">
                            <thead>
                                <th>Titulo</th>
                                <th>Precio</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha Final</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($publicaciones as $publicacion)
                                    <tr>
                                        <td>{{ $publicacion->titulo }}</td>
                                        <td>{{ $publicacion->precio }}</td>
                                        <td>{{ $publicacion->fechaInicio }}</td>
                                        <td>{{ $publicacion->fechaFinal }}</td>
                                        <td>
                                           

                                            <button type="button" class="btn btn-warning rounded-pill" data-toggle="modal"
                                                data-target="#editarPublicacionModal{{ $publicacion->id }}">
                                                <i class="bi bi-pencil-fill text-white"></i>
                                            </button>

                                            <form action="{{ route('publicaciones.destroy', $publicacion->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger rounded-pill"
                                                    onclick="confirmDelete(this)">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
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

        {{-- modal para crear publicaciones --}}
        <div class="modal fade" id="crearPublicacionModal" tabindex="-1" role="dialog"
            aria-labelledby="crearPublicacionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearPublicacionModalLabel">Agregar Publicaci&oacute;n</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('publicaciones.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="titulo" class="form-label">Titulo de la publicaci&oacute;n</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo"
                                            value="{{ old('titulo') }}" required>
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
                                <label for="rutaImagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="rutaImagen" name="rutaImagen"
                                    onchange="mostrarImagen()">
                                <img id="imagen-preview" class="rounded float-start" src="#" alt="Vista previa de la imagen"
                                    style="display: none; max-width: 100%; max-height: 200px; margin: 15px 10px 0 0;">
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
                                        <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" name="fechaInicio" id="fechaInicio">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaFinal" class="form-label">Fecha Final</label>
                                        <input type="date" class="form-control" name="fechaFinal" id="fechaFinal">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fechaInicio" class="form-label">Tratamiento</label>
                                        <select name="tratamiento_id" id="tratamiento_id" class="form-control">
                                            <option value="null" disabled selected>--Selecciona el Tratamiento--</option>
                                            @foreach ($tratamientos as $tratamiento)
                                                <option value="{{ $tratamiento->id }}">
                                                    {{ $tratamiento->nombreTratamiento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Crear Publicaci&oacute;n</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($publicaciones as $publicacion)
            <div class="modal fade" id="editarPublicacionModal{{ $publicacion->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editarPublicacionModalLabel{{ $publicacion->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarPublicacionModalLabel">Editar Publicaci&oacute;n</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('publicaciones.update', $publicacion->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="titulo" class="form-label">Titulo de la
                                                publicaci&oacute;n</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo"
                                                value="{{ $publicacion->titulo }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="descripcion" class="form-label">Descripción</label>
                                            <textarea class="form-control" rows="1" id="descripcion" name="descripcion" rows="3" required>{{ $publicacion->descripcion }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="imagenEditar" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" id="imagenEditar" name="rutaImagen"
                                        onchange="mostrarImagenEditar()">
                                    <img id="imagen-preview-editar" class="rounded float-start"
                                        src="{{ asset('img/publicaciones/' . $publicacion->rutaImagen) }}"
                                        alt="Vista previa de la imagen"
                                        style="max-width: 100%; max-height: 200px; margin: 15px 10px 0 0;">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="precio" class="form-label">Precio</label>
                                            <input type="number" class="form-control" id="precio" name="precio"
                                                value="{{ $publicacion->precio }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                                            <input type="date" class="form-control" name="fechaInicio"
                                                id="fechaInicio" value="{{ $publicacion->fechaInicio }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fechaFinal" class="form-label">Fecha Final</label>
                                            <input type="date" class="form-control" name="fechaFinal"
                                                id="fechaInicio" value="{{ $publicacion->fechaFinal }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fechaInicio" class="form-label">Tratamiento</label>
                                            <select name="tratamiento_id" id="tratamiento_id" class="form-control">
                                                <option value="null" disabled selected>--Selecciona el Tratamiento--
                                                </option>
                                                @foreach ($tratamientos as $tratamiento)
                                                    <option value="{{ $tratamiento->id }}"
                                                        {{ $tratamiento->id == $publicacion->tratamiento_id ? 'selected' : '' }}>
                                                        {{ $tratamiento->nombreTratamiento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Crear Publicaci&oacute;n</button>
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
    <script>
        $(document).ready(function() {
            $('#publicacionesTable').DataTable({
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
        function confirmDelete(button) {
            Swal.fire({
                title: '¿Estás seguro de eliminar el siguiente registro?',
                text: 'Una vez eliminada, no se podrá recuperar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Encuentra el elemento de formulario más cercano y envíalo
                    $(button).closest('form').submit();
                }
            });
        }

        function mostrarImagen() {
            var input = document.getElementById('rutaImagen');
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
                var publicacionRutaImagen = @json($publicacion->rutaImagen ?? null);

                if (publicacionRutaImagen) {
                    preview.src = "{{ asset('img/publicaciones/') }}" + '/' + publicacionRutaImagen;
                } else {
                    console.log("No hay tratamiento definido.");
                }
            }
        }
    </script>
@endsection
