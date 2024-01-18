@extends('adminlte::page')

@section('title', 'Citas Agendadas')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Lista de Citas</h3>

            <div class="col-md-12 mt-3">
                <form method="GET" action="{{ route('citas.agendadas') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="fecha">Buscar por Fecha:</label>
                            <input type="date" name="fecha" id="fecha" class="form-control"
                                value="{{ request('fecha') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="tratamiento_id">Buscar por Tratamiento:</label>
                            <select name="tratamiento_id" id="tratamiento_id" class="form-control">
                                <option value="">Seleccionar tratamiento</option>
                                @foreach ($tratamientos as $tratamiento)
                                    <option value="{{ $tratamiento->id }}"
                                        {{ request('tratamiento_id') == $tratamiento->id ? 'selected' : '' }}>
                                        {{ $tratamiento->nombreTratamiento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="estado">Filtrar por Estado:</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="" {{ request('estado') === '' ? 'selected' : '' }}>Todos</option>
                                <option value="e" {{ request('estado') === 'e' ? 'selected' : '' }}>En espera</option>
                                <option value="a" {{ request('estado') === 'a' ? 'selected' : '' }}>Atendidas</option>
                                <option value="c" {{ request('estado') === 'c' ? 'selected' : '' }}>Canceladas</option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 mt-5">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Citas Agendadas</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="citasTable" class="table table-hover table-sm table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Paciente</th>
                                        <th>Tratamiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citas as $cita)
                                        <tr>
                                            <td>{{ $cita->dia }}</td>
                                            <td>{{ $cita->hora }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $cita->estado == 'e' ? 'bg-info' : ($cita->estado == 'c' ? 'bg-warning' : 'bg-success') }}">
                                                    {{ $cita->estado == 'e' ? 'En espera' : ($cita->estado == 'c' ? 'Cancelada' : ($cita->estado == 'a' ? 'Atendida' : $cita->estado)) }}
                                                </span>
                                            </td>

                                            <td>{{ $cita->paciente->nombres . ' ' . $cita->paciente->apellidos }}</td>
                                            <td>{{ $cita->tratamiento->nombreTratamiento }}</td>
                                            <td>
                                                @if ($cita->estado == 'e')
                                            
                                                    <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Cancelar">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('#citasTable').DataTable({
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
        // Manejar el cambio en el filtro de estado
        $('#estado').on('change', function() {
            // Recargar la tabla al cambiar el filtro de estado
            citasTable.ajax.reload();
        });
    </script>
@endsection
