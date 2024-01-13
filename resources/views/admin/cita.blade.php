@extends('adminlte::page')
@section('content')
    <div class="container mt-5">
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
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center fw-bold mb-3"><i class="bi bi-clipboard-check"></i>&nbsp;Agendar cita&nbsp;
                            <i class="bi bi-clipboard-check"></i>
                        </h3>
                        <!-- Formulario para buscar disponibilidad -->
                        <form action="{{ route('disponibilidad') }}" method="GET" class="row"
                            id="buscarDisponibilidadForm">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tratamiento_id" class="form-label">Buscar Cupos disponibles</label>
                                    <select class="form-control" name="tratamiento_id" id="tratamiento_id">
                                        <option disabled selected>Seleccione el tratamiento</option>
                                        @foreach ($tratamientos as $tratamiento)
                                            <option value="{{ $tratamiento->id }}">{{ $tratamiento->nombreTratamiento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3 text-md-end">
                                <button type="submit" class="btn btn-secondary rounded-pill"><i class="bi bi-search"></i>
                                    &nbsp;Buscar Disponibilidad</button>
                            </div>
                        </form>

                        <!-- Formulario para guardar cita -->
                        <form action="{{ route('citas.store') }}" method="POST" class="row mt-4" id="guardarCitaForm">
                            @csrf
                            <input type="hidden" name="paciente_id" value="{{ request('id') }}">
                            <input type="hidden" name="tratamiento_id" id="selectedTratamientoId">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dia" class="form-label">Día seleccionado</label>
                                    <input type="text" class="form-control" id="selectedDay" name="dia" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hora" class="form-label">Hora seleccionada</label>
                                    <input type="text" class="form-control" id="selectedHour" name="hora" readonly>
                                </div>
                            </div>

                            <div class="col-md-4 mt-md-0 mt-3 text-md-end">
                                <button type="submit" class="btn btn-success rounded-pill" id="guardarCitaBtn"
                                    disabled>Guardar Cita</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-lg-8 col-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h3 class="text-center mb-3">Calendario</h3>
                            <div id='calendar' style='width: 100%;'></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h3 class="text-center mb-3">Horas Disponibles</h3>
                            <div id="horas-container"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
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
            });

          // Función para mostrar solo las horas disponibles
function mostrarHorasDisponibles(horasDisponibles, horasOcupadas) {
    // Obtener el contenedor div donde se mostrarán las horas
    var horasContainer = document.getElementById('horas-container');

    // Limpiar el contenido previo
    horasContainer.innerHTML = '';

    // Formatear las horas ocupadas para que coincidan con el formato de las horas disponibles
    var horasOcupadasFormateadas = horasOcupadas.map(function (hora) {
        return formatHour(new Date('2000-01-01 ' + hora).getHours(), new Date('2000-01-01 ' + hora).getMinutes());
    });

    // Filtrar las horas disponibles para excluir las horas ocupadas
    var horasDisponiblesFiltradas = horasDisponibles.filter(function (hora) {
        return !horasOcupadasFormateadas.includes(hora);
    });

    // Crear y agregar radio buttons por cada hora disponible
    horasDisponiblesFiltradas.forEach(function (hora, index) {
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




        });
    </script>
@endsection
