@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3 class="mt-3">Listado de Antecedentes M&eacute;dicos</h3>
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
                            data-target="#crearAntMedModal"> <i class="bi bi-plus-circle-fill"></i>Agregar
                        </button>
                        <hr>
                        <table id="antecedentesTable" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Paciente</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($antecedentes_medicos as $antecedente)
                                    <tr>
                                        @php
                                            $pacienteCorrespondiente = null;
                                            foreach ($pacientesByAnteced as $paciente) {
                                                if ($paciente->id == $antecedente->paciente_id) {
                                                    $pacienteCorrespondiente = $paciente;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        <td class="text-center">{{ $pacienteCorrespondiente->codigo }}</td>
                                        <td>{{ $pacienteCorrespondiente->nombres }}&nbsp;{{$pacienteCorrespondiente->apellidos}}</td>

                                        <td class="text-center">
                                            <a href="{{ route('antecedente', ['paciente_id' => $antecedente->paciente_id]) }}"
                                                class="btn btn-info rounded-pill"> <i class="bi bi-eye-fill text-white"></i>
                                            </a>

                                            <button type="button" class="btn btn-warning rounded-pill" data-toggle="modal"
                                                data-target="#editarAntMedModal{{ $antecedente->id }}">
                                                <i class="bi bi-pencil-fill text-white"></i>
                                            </button>

                                            <form action="{{ route('antecedentes.destroy', $antecedente->id) }}"
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
        <div class="modal fade" id="crearAntMedModal" tabindex="-1" role="dialog" aria-labelledby="crearAntMedModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearAntMedModalLabel">Agregar Paciente</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('antecedentes.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="container">

                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="hipertension" class="">Paciente</label>
                                        <select class="form-control" id="paciente_id" name="paciente_id" required>
                                            <option selected disabled>Escoger Paciente</option>
                                            @foreach ($allPacientes as $paciente)
                                                <option value="{{ $paciente->id }}">
                                                    {{ $paciente->apellidos }}&nbsp;{{ $paciente->nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="hipertension" class="">Hipertensión Arterial</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="hipertencionArterial" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="hipertencionArterial" value="0"checked> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cardiopatia" class="">Cardiopatía</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="cardiopatia" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="cardiopatia" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="diabetesMellitu" class="">Diabetes Mellitus</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="diabetesMellitu" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="diabetesMellitu" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="renal" class="">Problema Renal</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="problemaRenal" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="problemaRenal" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="problemaRespiratorio" class="">Problema Respiratorio</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="problemaRespiratorio" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="problemaRespiratorio" value="0" checked>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hepatico" class="">Problema Hepático</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="problemaHepatico" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="problemaHepatico" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="problemaEndocronico" class="">Problema Endocrino</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="problemaEndocrino" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="problemaEndocrino" value="0" checked>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="problemaHemorragico" class="">Problema Hemorragico</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="problemaHemorragico" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="problemaHemorragico" value="0" checked>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col-md-6">
                                        <label for="embarazo" class="">Embarazo</label>
                                        <div class="form-check">
                                            <label class="">
                                                <input type="radio" name="embarazo" value="1"> Si
                                            </label>
                                            <label class="mx-4">
                                                <input type="radio" name="embarazo" value="0" checked> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="alergiaMedicamentos" class="">Alergia a Medicamentos</label>
                                        <textarea type="text" class="form-control" id="alergiaMedicamentos" name="alergiaMedicamentos" rows="3" maxlength="255"> </textarea>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-md-6">
                                        <label for="otrosMedicamentosQueToma" class="">Otros medicamentos</label>
                                        <textarea type="text" class="form-control" id="otrosMedicamentosQueToma" name="otrosMedicamentosQueToma" rows="3" maxlength="255"> </textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="otrosDatos">Otros Datos</label>
                                        <textarea type="text" class="form-control" id="otrosDatos" name="otrosDatos" rows="3" maxlength="255"> </textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6 float-end">
                                <button type="submit" class="btn btn-primary col-md-6">Enviar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            $('#antecedentesTable').DataTable({
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
