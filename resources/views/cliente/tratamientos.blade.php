@extends('layouts.index')
@section('content')
<div class="container mt-4">
    <br>
    <br>
    <div class="row">
        @isset($tratamientos)
            @foreach ($tratamientos as $tratamiento)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header bg-secondary fw-bold text-white"> <span><i
                                    class="bi bi-person-badge-fill"></i></span>
                            {{ $tratamiento->nombreTratamiento }}
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/tratamientos/' . $tratamiento->nombreImagen) }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <p class="card-text"> <b>Precio: </b> {{ $tratamiento->precio }}</p>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> <b>Descripcion:</b> {{ $tratamiento->descripcion }}</p>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <div>
                                <!-- Botón de Ver Citas con ícono -->
                                <a href="{{route('citas.create')}}" class="btn btn-secondary rounded-pill">
                                    <i class="bi bi-calendar-range-fill"></i> Agendar Citas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</div>

@endsection
