@extends('adminlte::page')

@section('title', 'Radiografias')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Lista de Radiografias</h3>
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
                            data-target="#crearRadiografiaModal"> <i class="bi bi-plus-circle-fill"></i>
                            Agregar
                        </button>
                        <hr>
                        <table id="radiografiasTable" class="table table-hover table-sm table-bordered text-center">
                            <thead>
                                <th>C&oacute;digo</th>
                                <th>Paciente</th>
                                {{-- <th>Fecha</th> --}}
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $paciente)
                                    <tr>

                                        <td>{{ $paciente->codigo }}</td>
                                        <td>{{ $paciente->nombres }}</td>
                                        <td>
                                            <a href="{{ route('radiografia', ['paciente_id' => $paciente->id]) }}"
                                                class="btn btn-info rounded-pill fw-bold text-white"> <i class="bi bi-eye-fill text-white"></i>
                                                Ver
                                            </a>
                                            {{-- <button type="button" class="btn btn-warning rounded-pill" data-toggle="modal"
                                            data-target="#editarDoctorModal{{ $radiografia->id }}">
                                            <i class="bi bi-pencil-fill text-white"></i>
                                        </button> --}}
                                            {{-- <form action="{{ route('radiografias.destroy', $radiografia->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Eliminar" type="button" class="btn btn-danger rounded-pill"
                                                onclick="confirmDelete(this)"><i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal para POST --}}
        <div class="modal fade" id="crearRadiografiaModal" tabindex="-1" role="dialog"
            aria-labelledby="crearRadiografiaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearRadiografiaModalLabel">Agregar</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('radiografias.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nombreRadiografia" class="form-label">Nombre Radiografia</label>
                                <input type="file" class="form-control" id="nombreRadiografia"
                                    name="nombreRadiografia">
                            </div>

                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Fecha en que se realiz&oacute;</label>
                                <input type="date" class="form-control" id="fechaRealizada" name="fechaRealizada"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="user_id" class="form-label">Paciente</label>
                                <select class="form-control" id="paciente_id" name="paciente_id" required>
                                    <option selected disabled>Seleccione un Paciente</option>
                                    @foreach ($pacientes as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nombres }}&nbsp;{{ $item->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tratamiento_id" class="form-label">Tratamiento</label>
                                <select class="form-control tratamientos" id="tratamientos" name="tratamiento_id">
                                    <option selected disabled>Seleccione un tratamiento</option>
                                    @foreach ($tratamientos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombreTratamiento }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Doctor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')





    <script>
        $(document).ready(function() {
            //$('.tratamientos').select2();
            $('#radiografiasTable').DataTable({
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
@endsection
