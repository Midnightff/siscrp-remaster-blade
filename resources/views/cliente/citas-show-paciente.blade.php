@extends('layouts.index')

@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <div class="container">
        <div class="row">
            <h2>Listado de Citas</h2>

            @if (count($citas) > 0)
                @foreach ($citas as $cita)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border shadow">
                            <div class="card-body">
                                <p class=""><i class="bi bi-calendar-event-fill"></i> <b>Fecha de la Cita:</b>
                                    <span class="fst-italic">{{ $cita->dia }}</span>
                                </p>
                                <p class=""><i class="bi bi-clock-fill"></i> <b>Hora:</b> <span
                                        class="fst-italic">{{ $cita->hora }}</span></p>
                                <p class=""><i class="bi bi-clipboard-pulse"></i> <b>Estado de la cita:</b> <span
                                        class="text-capitalize fst-italic">{{ $cita->estado === 'e' ? 'En proceso' : $cita->estado }}</span>
                                </p>

                                <p class=""><i class="bi bi-info-circle-fill"></i> <b>Procedimiento a realizar:</b>
                                    <span
                                        class="text-capitalize fst-italic">{{ $cita->tratamiento->nombreTratamiento }}</span>
                                </p>
                                <form action="{{ route('cita.cancelar', ['id' => $cita->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle"></i> Cancelar Cita
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h4>No hay citas disponibles.</h4>
            @endif
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.1);
        }
    </style>


@endsection
