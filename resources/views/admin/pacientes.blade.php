@extends('adminlte::page')

@section('title', 'Pacientes')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Lista de Pacientes</h3>
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
                            data-target="#crearPacienteModal"> <i class="bi bi-plus-circle-fill"></i>
                            Agregar
                        </button>
                        <hr>
                        <table id="pacientesTable" class="table table-hover table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>G&eacute;nero</th>
                                    <th>Tel&eacute;fono</th>
                                    <th>Edad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $paciente)
                                    <tr>
                                        <td>{{ $paciente->codigo }}</td>
                                        <td>{{ $paciente->apellidos }}</td>
                                        <td>{{ $paciente->nombres }}</td>
                                        <td>{{ $paciente->sexo === 'm' ? 'Masculino' : ($paciente->sexo === 'f' ? 'Femenino' : $paciente->sexo) }}
                                        </td>
                                        <td>{{ $paciente->numeroTelefonico }}</td>
                                        <td>{{ $paciente->fechaNacimiento }}&nbsp;a&#241os</td>
                                        <td>
                                            <a href="{{ route('citas.index', ['id' => $paciente->id]) }}"
                                                class="btn btn-warning rounded-pill">
                                                <i class="bi bi-calendar-plus-fill text-white"></i>
                                            </a>

                                            <a href="{{ route('odontograma.index', ['id' => $paciente->id]) }}"
                                                class="btn btn-warning rounded-pill">
                                                <i class="bi bi-file-text text-white"></i>
                                           
                                            </a>



                                            <a href="{{ route('mostrar-consultas', ['id' => $paciente->id]) }}"
                                                class="btn btn-warning rounded-pill">
                                                <i class="bi bi-file-text"></i>
                                            </a>


                                            <button type="button" class="btn btn-warning rounded-pill" data-toggle="modal"
                                                data-target="#editarPacienteModal{{ $paciente->id }}">
                                                <i class="bi bi-pencil-fill text-white"></i>
                                            </button>

                                            <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST"
                                                style="display: inline;">
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

        <!-- Modal para agregar paciente -->
        <div class="modal fade" id="crearPacienteModal" tabindex="-1" role="dialog"
            aria-labelledby="crearPacienteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearPacienteModalLabel">Agregar Paciente</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('pacientes.store') }}" enctype="multipart/form-data">
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
                                <div class="col-md-12 mb-3">
                                    <label for="user_id" class="form-label">Usuario</label>
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        <option selected disabled>Seleccione un usuario</option>
                                        @foreach ($usuarios as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
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

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar tratamiento -->
        @foreach ($pacientes as $paciente)
            <div class="modal fade" id="editarPacienteModal{{ $paciente->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editarPacienteModalLabel{{ $paciente->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarTratamientoModalLabel">Editar
                                Paciente</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="nombres" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="nombres" name="nombres"
                                                value="{{ $paciente->nombres }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                                value="{{ $paciente->apellidos }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="numeroTelefonico" class="form-label">Tel&eacute;fono</label>
                                            <input type="text" class="form-control" id="numeroTelefonico"
                                                name="numeroTelefonico" value="{{ $paciente->numeroTelefonico }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
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
            $('#pacientesTable').DataTable({
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
    </script>
@endsection
