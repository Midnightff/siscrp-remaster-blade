@extends('adminlte::page')

@section('title', 'Doctores')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Lista de Doctores</h3>
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
                            data-target="#crearDoctorModal"> <i class="bi bi-plus-circle-fill"></i>
                            Agregar
                        </button>
                        <hr>
                        <table id="doctoresTable" class="table table-hover table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Sexo</th>
                                    <th>Especialidad</th>
                                    <th>Número Telefónico</th>
                                    <th>Horarios</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctores as $doctor)
                                    <tr>

                                        <td>{{ $doctor->nombres }}</td>
                                        <td>{{ $doctor->apellidos }}</td>
                                        <td>{{ $doctor->sexo === 'm' ? 'Masculino' : ($doctor->sexo === 'f' ? 'Femenino' : 'Otro') }}
                                        </td>
                                        <td>{{ $doctor->tratamiento->nombreTratamiento }}</td>
                                        <td>{{ $doctor->numeroTelefonico }}</td>
                                        <td>
                                            <!-- Celda para mostrar los horarios -->
                                            <ul>
                                                @foreach ($doctor->horarios as $horario)
                                                    <li>
                                                        @php
                                                            // Mapear las abreviaturas de días
                                                            $diasAbreviados = [
                                                                'l' => 'lunes',
                                                                'm' => 'martes',
                                                                'mi' => 'miércoles',
                                                                'j' => 'jueves',
                                                                'v' => 'viernes',
                                                                's' => 'sábado',
                                                            ];

                                                            // Obtener las abreviaturas de días de la cadena y dividirlas de manera precisa
                                                            $abreviaturasDias = preg_split('/,\s*/', $horario->dias);

                                                            // Filtrar y traducir los días, eliminando espacios adicionales
                                                            $diasTraducidos = array_map(function ($abreviaturaDia) use ($diasAbreviados) {
                                                                return trim($abreviaturaDia) !== '' ? $diasAbreviados[trim($abreviaturaDia)] ?? $abreviaturaDia : null;
                                                            }, $abreviaturasDias);

                                                            // Filtrar los días traducidos para eliminar posibles valores nulos
                                                            $diasTraducidos = array_filter($diasTraducidos);

                                                            // Mostrar los días traducidos
                                                            echo implode(', ', $diasTraducidos);
                                                        @endphp
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </td>





                                        <td>
                                            <button type="button" class="btn btn-warning rounded-pill" data-toggle="modal"
                                                data-target="#editarDoctorModal{{ $doctor->id }}">
                                                <i class="bi bi-pencil-fill text-white"></i>
                                            </button>
                                            <form action="{{ route('doctores.destroy', $doctor->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Eliminar" type="button" class="btn btn-danger rounded-pill"
                                                    onclick="confirmDelete(this)"><i class="bi bi-trash-fill"></i>
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

        <!-- Modal para agregar tratamiento -->
        <div class="modal fade" id="crearDoctorModal" tabindex="-1" role="dialog"
            aria-labelledby="crearTratamientoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearDoctorModalLabel">Agregar Doctor</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('doctores.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>

                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>

                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="m">Masculino</option>
                                    <option value="f">Femenino</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="numeroTelefonico" class="form-label">Número Telefónico</label>
                                <input type="tel" class="form-control" id="numeroTelefonico" name="numeroTelefonico"
                                    required>
                            </div>


                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuario</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option selected disabled>Seleccione un usuario</option>
                                    @foreach ($usuarios as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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

                            <h4 class="mb-4">Horarios</h4>

                            <div class="mb-3">
                                <label class="form-label">Seleccionar Horarios:</label>
                                <div class="btn-group" role="group">
                                    @php
                                        $diasCompletos = [
                                            'l' => 'Lunes',
                                            'm' => 'Martes',
                                            'mi' => 'Miércoles',
                                            'j' => 'Jueves',
                                            'v' => 'Viernes',
                                            's' => 'Sábado',
                                        ];
                                    @endphp

                                    @foreach ($diasCompletos as $abreviatura => $nombreCompleto)
                                        <input type="checkbox" class="btn-check" name="horarios[0][dias][]"
                                            value="{{ $abreviatura }}" id="checkbox{{ $abreviatura }}"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary"
                                            for="checkbox{{ $abreviatura }}">{{ $nombreCompleto }}</label>
                                    @endforeach
                                </div>
                            </div>




                            <button type="submit" class="btn btn-primary">Guardar Doctor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar doctores -->
        @foreach ($doctores as $doctor)
            <div class="modal fade" id="editarDoctorModal{{ $doctor->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editarDoctorModalLabel{{ $doctor->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarTratamientoModalLabel">Editar
                                Doctor</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('doctores.update', $doctor->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="nombres" class="form-label">Nombres</label>
                                            <input type="text" class="form-control" id="nombres" name="nombres"
                                                value="{{ $doctor->nombres }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="apellidos" class="form-label">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                                value="{{ $doctor->apellidos }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="numeroTelefonico" class="form-label">Tel&eacute;fono</label>
                                            <input type="text" class="form-control" id="numeroTelefonico"
                                                name="numeroTelefonico" value="{{ $doctor->numeroTelefonico }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="tratamiento" class="form-label">Tratamiento</label>
                                            <select class="form-control" id="tratamiento" name="tratamiento_id">
                                                <option selected disabled>Seleccione un tratamiento</option>
                                                @foreach ($tratamientos as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $doctor->tratamiento_id ? 'selected' : '' }}>
                                                        {{ $item->nombreTratamiento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección para los horarios -->
                                <div class="mb-3">
                                    <label class="form-label">Horarios:</label>

                                    @foreach ($diasCompletos as $abreviatura => $nombreCompleto)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" name="horarios[0][dias][]"
                                                value="{{ $abreviatura }}" id="editarCheckbox{{ $abreviatura }}"
                                                {{ strpos($doctor->horarios[0]->dias, $abreviatura) !== false ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="editarCheckbox{{ $abreviatura }}">{{ $nombreCompleto }}</label>
                                        </div>
                                    @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script></script>

    <script>
        $(document).ready(function() {
            //$('.tratamientos').select2();
            $('#doctoresTable').DataTable({
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
                    $(button).closest('form').submit();
                }
            });
        }
    </script>
@endsection
