@extends('layouts.index')

@section('content')
    <div class="container mt-4">
        <!-- Mensajes de sesión con SweetAlert -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @elseif(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        <br>
        <br>
        <button type="button" class="btn btn-success p-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
            id="btnAgregarPaciente">
            <i class="bi bi-plus-square-fill text-white"></i> Agregar paciente
        </button>
        <br>
        <br>
        <div class="row">
            @isset($pacientes)
                @foreach ($pacientes as $paciente)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-header bg-secondary fw-bold text-white"> <span><i
                                        class="bi bi-person-badge-fill"></i></span>
                                {{ $paciente->nombres }}
                            </div>
                            <div class="card-body">
                                <p class="card-text"> <b>N° Codigo Clínico:</b> {{ $paciente->codigo }}</p>
                                <p class="card-text"><b>Fecha de nacimiento:</b> {{ $paciente->fechaNacimiento }}</p>
                                <p class="card-text"> <b>Numero de teléfono:</b> {{ $paciente->numeroTelefonico }}</p>
                            </div>
                            <div class="card-footer bg-light d-flex justify-content-between">
                                <div>
                                    <button type="button" class="btn btn-warning rounded-pill" data-bs-toggle="modal"
                                        data-bs-target="#editarPacienteModal{{ $paciente->id }}">
                                        <i class="bi bi-pencil-fill text-white"></i> Editar
                                    </button>
                                </div>
                                <div>
                                    <!-- Botón de Ver Citas con ícono -->
                                    <a href="{{ route('mostrar-citas-paciente', ['paciente_id' => $paciente->id]) }}"
                                        class="btn btn-secondary rounded-pill">
                                        <i class="bi bi-calendar-range-fill"></i> Ver Citas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                    <input type="text" class="form-control" id="numeroTelefonico" name="numeroTelefonico"
                                        value="{{ old('numeroTelefonico') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento">
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
                        <form method="POST" action="{{ route('update-cliente', $paciente->id) }}"
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
                                            name="numeroTelefonico" value="{{ $paciente->numeroTelefonico }}" required>
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



    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendar;

            // Manejar la presentación del calendario después de enviar el formulario
            $('#buscarDisponibilidadForm').submit(function(event) {
                event.preventDefault();

                // Realizar la llamada AJAX para obtener la disponibilidad de los doctores
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'GET',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Obtener el mes y año actual
                        var fechaActual = new Date();
                        var mesActual = fechaActual.getMonth() +
                            1; // Los meses en JavaScript son de 0 a 11
                        var anioActual = fechaActual.getFullYear();

                        // Inicializar el calendario con la respuesta recibida
                        calendar = new FullCalendar.Calendar(document.getElementById(
                            'calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            initialView: 'dayGridMonth',
                            events: response.map(function(doctorAvailability) {
                                    // Separar los días disponibles en un array
                                    var dias_disponibles = doctorAvailability
                                        .dias_disponibles[0].split(',');

                                    // Generar fechas para los días disponibles
                                    var fechas_disponibles =
                                        generateFechasDisponibles(dias_disponibles,
                                            mesActual, anioActual);

                                    // Mapear fechas disponibles a eventos del calendario
                                    return fechas_disponibles.map(function(fecha) {
                                        return {
                                            title: 'Disponible',
                                            start: fecha,
                                            allDay: true, // Evento de todo el día
                                            selectable: true, // Permitir la selección
                                        };
                                    });

                                })
                                .flat(),
                            // Utilizar flat para "aplanar" el array de eventos
                            selectable: true, // Permitir la selección de fechas
                            select: function(info) {
                                // Obtener las horas ocupadas para el día seleccionado mediante AJAX
                                $.ajax({
                                    url: '/getHorasOcupadas/' + info
                                        .startStr,
                                    method: 'GET',
                                    success: function(response) {
                                        var horasOcupadas = response
                                            .horas_ocupadas;

                                        // Validar que no sea un domingo ni un día anterior al día de hoy
                                        if (info.start.getDay() === 0 ||
                                            info.start < fechaActual) {
                                            alert(
                                                'No puedes seleccionar días domingos ni días anteriores al día de hoy.'
                                            );
                                            calendar
                                                .unselect(); // Deshacer la selección
                                        } else {
                                            // Aquí puedes manejar la lógica cuando se selecciona una fecha
                                            console.log(
                                                'Fecha seleccionada:',
                                                info.startStr);

                                            // Obtener las horas disponibles para el día seleccionado
                                            var horasDisponibles =
                                                getHorasDisponibles(info
                                                    .start);
                                            console.log(
                                                'Horas disponibles:',
                                                horasDisponibles);
                                            // Después de obtener las horas ocupadas
                                            var horasOcupadas = response
                                                .horas_ocupadas;

                                            // Mostrar las horas disponibles en un div con radio buttons
                                            mostrarHorasDisponibles(
                                                horasDisponibles,
                                                horasOcupadas);


                                            // Actualizar los campos del formulario
                                            $('#selectedDay').val(info
                                                .startStr);

                                            // Cuando se selecciona una hora del div con radio buttons
                                            $('input[name="hora-disponible"]')
                                                .on('change',
                                                    function() {
                                                        // Obtener la hora seleccionada
                                                        var selectedHour =
                                                            $(this)
                                                            .val();

                                                        // Verificar si la hora seleccionada ya está ocupada
                                                        if (horasOcupadas
                                                            .includes(
                                                                selectedHour
                                                            )) {
                                                            alert(
                                                                'La hora seleccionada ya está ocupada. Por favor, elige otra hora.'
                                                            );
                                                            $('input[name="hora-disponible"]')
                                                                .prop(
                                                                    'checked',
                                                                    false
                                                                );
                                                            $('#guardarCitaBtn')
                                                                .prop(
                                                                    'disabled',
                                                                    true
                                                                );
                                                        } else {
                                                            // Actualizar la etiqueta y el campo de entrada con la hora seleccionada
                                                            $('#selectedHour')
                                                                .val(
                                                                    selectedHour
                                                                );
                                                            $('label[for="hora"]')
                                                                .text(
                                                                    'Hora seleccionada: ' +
                                                                    selectedHour
                                                                );
                                                            // Obtener el tratamiento seleccionado
                                                            var selectedTratamientoId =
                                                                $(
                                                                    '#tratamiento_id option:selected'
                                                                )
                                                                .val();
                                                            $('#selectedTratamientoId')
                                                                .val(
                                                                    selectedTratamientoId
                                                                );
                                                            // Habilitar el botón de guardar cita
                                                            $('#guardarCitaBtn')
                                                                .prop(
                                                                    'disabled',
                                                                    false
                                                                );
                                                        }
                                                    });
                                            console.log(
                                                'Horas ocupadas:',
                                                horasOcupadas);


                                        }
                                    },
                                    error: function(error) {
                                        console.error(
                                            'Error al obtener las horas ocupadas:',
                                            error);
                                    }
                                });

                            },
                        });

                        // Rerenderizar el calendario
                        calendar.render();
                    },

                    error: function(error) {
                        console.error('Error en la llamada AJAX:', error);
                    }
                });

                // Hacer una solicitud AJAX para obtener los pacientes
                $.ajax({
                    url: '{{ route('obtener-pacientes') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.pacientes && response.pacientes.length > 0) {
                            // Llenar el select con los pacientes obtenidos
                            var select = $('#paciente_id');
                            select.empty();
                            select.append($('<option>', {
                                value: '',
                                text: 'Selecciona un paciente'
                            }));

                            $.each(response.pacientes, function(index, paciente) {
                                select.append($('<option>', {
                                    value: paciente.id,
                                    text: paciente.nombres
                                }));
                            });
                        } else {
                            // Manejar el caso en que no haya pacientes disponibles
                            console.log('No hay pacientes disponibles.');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error al obtener los pacientes:', textStatus,
                            errorThrown);
                    }
                });




            });

            // Función para mostrar solo las horas disponibles
            function mostrarHorasDisponibles(horasDisponibles, horasOcupadas) {
                // Obtener el contenedor div donde se mostrarán las horas
                var horasContainer = document.getElementById('horas-container');

                // Limpiar el contenido previo
                horasContainer.innerHTML = '';

                // Formatear las horas ocupadas para que coincidan con el formato de las horas disponibles
                var horasOcupadasFormateadas = horasOcupadas.map(function(hora) {
                    return formatHour(new Date('2000-01-01 ' + hora).getHours(), new Date('2000-01-01 ' +
                        hora).getMinutes());
                });

                // Filtrar las horas disponibles para excluir las horas ocupadas
                var horasDisponiblesFiltradas = horasDisponibles.filter(function(hora) {
                    return !horasOcupadasFormateadas.includes(hora);
                });

                // Crear y agregar radio buttons por cada hora disponible
                horasDisponiblesFiltradas.forEach(function(hora, index) {
                    // Crear un nuevo radio button
                    var radioButton = document.createElement('input');
                    radioButton.type = 'radio';
                    radioButton.name = 'hora-disponible';
                    radioButton.value = hora;

                    // Crear una etiqueta (label) para el radio button
                    var label = document.createElement('label');
                    label.innerText = hora;

                    // Crear un salto de línea para separar los radio buttons
                    var lineBreak = document.createElement('br');

                    // Agregar el radio button y la etiqueta al contenedor
                    horasContainer.appendChild(radioButton);
                    horasContainer.appendChild(label);
                    horasContainer.appendChild(lineBreak);
                });
            }





            // Función para generar fechas disponibles basadas en los días disponibles y el mes actual
            function generateFechasDisponibles(dias_disponibles, mes, anio) {
                var fechas = [];

                // Iterar sobre los días disponibles
                dias_disponibles.forEach(function(dia) {
                    // Obtener el día de la semana correspondiente al día disponible
                    var diaSemana = getDiaSemana(dia);

                    // Obtener la fecha del primer día disponible en el mes actual
                    var fecha = new Date(anio, mes - 1, 1);

                    // Encontrar el primer día de la semana correspondiente al día disponible
                    while (fecha.getDay() !== diaSemana) {
                        fecha.setDate(fecha.getDate() + 1);
                    }

                    // Agregar las fechas disponibles en el mes
                    while (fecha.getMonth() === mes - 1) {
                        fechas.push(formatDate(fecha));
                        fecha.setDate(fecha.getDate() +
                            7); // Avanzar al siguiente día de la semana correspondiente
                    }
                });

                return fechas;
            }

            // Función para obtener el número del día de la semana basado en su nombre en español
            function getDiaSemana(nombreDia) {
                switch (nombreDia.trim().toLowerCase()) {
                    case 'l':
                        return 1;
                    case 'm':
                        return 2;
                    case 'mi':
                        return 3;
                    case 'j':
                        return 4;
                    case 'v':
                        return 5;
                    case 's':
                        return 6;
                    default:
                        return -1; // Valor por defecto o indicador de error
                }
            }

            // Función para formatear una fecha en el formato 'YYYY-MM-DD'
            function formatDate(fecha) {
                var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                var dia = fecha.getDate().toString().padStart(2, '0');
                return fecha.getFullYear() + '-' + mes + '-' + dia;
            }

            // Función para obtener las horas disponibles para el día seleccionado
            function getHorasDisponibles(fechaSeleccionada) {
                var horasDisponibles = [];
                var horaInicio = 8; // Hora de inicio (8 am)
                var horaFin = 16; // Hora de fin (4 pm)

                var fecha = new Date(fechaSeleccionada);

                // Verificar si el día seleccionado es un sábado
                if (fecha.getDay() === 6) { // 6 representa el sábado
                    horaFin = 12; // Cambiar la hora de fin a las 12 pm para sábados
                }

                fecha.setHours(horaInicio, 0, 0, 0); // Establecer la hora de inicio

                // Iterar en intervalos de 30 minutos hasta la hora de fin
                while (fecha.getHours() < horaFin) {
                    // Omitir la hora de las 12 a 1 pm
                    if (!(fecha.getHours() === 12 && fecha.getMinutes() === 0)) {
                        horasDisponibles.push(formatHour(fecha.getHours(), fecha.getMinutes()));
                    }

                    fecha.setMinutes(fecha.getMinutes() + 30); // Añadir 30 minutos
                }

                return horasDisponibles;
            }

            // Función para formatear la hora en el formato 'HH:mm'
            function formatHour(hora, minutos) {
                return hora.toString().padStart(2, '0') + ':' + minutos.toString().padStart(2, '0');
            }

            // Realiza una solicitud AJAX para obtener la cantidad de pacientes
            $.ajax({
                url: '{{ route('obtener-cantidad-pacientes') }}',
                type: 'GET',
                success: function(response) {
                    if (response.cantidadPacientes >= 5) {
                        // Si tiene 5 o más pacientes, desactivar el botón de "Agregar paciente"
                        $('#btnAgregarPaciente').prop('disabled', true);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error al obtener la cantidad de pacientes:',
                        textStatus,
                        errorThrown);
                }
            });


        });
    </script>

@endsection
