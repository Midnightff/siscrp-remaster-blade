@extends('adminlte::page')

@section('title', 'Expediente')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Expediente</h3>
            <div class="col-md-12 mt-5">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Consultas del Paciente: {{ $paciente->nombres }} {{ $paciente->apellidos }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="consultasTable" class="table table-hover table-sm table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Estado</th>
                                        <th>Día</th>
                                        <th>Hora</th>
                                        <th>Tratamiento</th>
                                        <th>Doctor</th>
                                        <th>Observación</th>
                                        <th>Costo de Consulta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($consultas as $consulta)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge {{ $consulta->cita->estado == 'e' ? 'bg-info' : ($consulta->cita->estado == 'c' ? 'bg-warning' : 'bg-success') }}">
                                                    {{ $consulta->cita->estado == 'e' ? 'En espera' : ($consulta->cita->estado == 'c' ? 'Cancelada' : 'Atendida') }}
                                                </span>
                                            </td>
                                            <td>{{ $consulta->cita->dia }}</td>
                                            <td>{{ $consulta->cita->hora }}</td>
                                            <td>{{ $consulta->cita->tratamiento->nombreTratamiento }}</td>
                                            <td>
                                                @foreach ($consulta->cita->tratamiento->doctores as $doctor)
                                                    {{ $doctor->nombres }} {{ $doctor->apellidos }}
                                                @endforeach
                                            </td>
                                            <td>{{ $consulta->observacion }}</td>
                                            <td>{{ $consulta->costoConsulta }}</td>
                                            <td>
                                                <a 
                                                    class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editarConsultaModal{{ $consulta->id }}"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                @if ($consulta->cita->estado == 'e')
                                                <form action="{{ route('consultas.atender', $consulta->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Atender">
                                                        <i class="bi bi-check-lg"></i>
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
        <!-- Modal para editar tratamiento -->
        @foreach ($consultas as $consulta)
            <div class="modal fade" id="editarConsultaModal{{ $consulta->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editarPacienteModalLabel{{ $consulta->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarTratamientoModalLabel">Editar
                                Consulta</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                    
                    
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <textarea name="observacion" id="observacion" class="form-control" rows="3">{{ $consulta->observacion }}</textarea>
                                </div>
                    
                                <div class="form-group">
                                    <label for="costoConsulta">Costo de Consulta</label>
                                    <input type="text" name="costoConsulta" id="costoConsulta" class="form-control" value="{{ $consulta->costoConsulta }}">
                                </div>
                    
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('#consultasTable').DataTable({
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
@endsection
