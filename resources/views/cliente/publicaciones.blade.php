@extends('layouts.index')
@section('content')
<div class="container mt-4">
    <br>
    <br>
    <div class="row">
        @isset($publicaciones)
            @foreach ($publicaciones as $publicacion)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow">
                        <div class="card-header bg-secondary fw-bold text-white"> <span><i
                                    class="bi bi-person-badge-fill"></i></span>
                            {{ $publicacion->titulo}}
                        </div>
                        <div class="card-body">
                            <img src="{{ asset('img/publicaciones/' . $publicacion->rutaImagen) }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <p class="card-text"> <b>Descripcion: </b> {{ $publicacion->descripcion }}</p>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> <b>Precio:</b> {{ $publicacion->precio }}</p>    
                        </div>
                        <div class="card-body">
                            <p class="card-text">Promocion valida hasta: {{ $publicacion->fechaFinal }}</p>    
                        </div>
                        
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <div>
                                <!-- Botón de Ver Citas con ícono -->
                                <a href="#" class="btn btn-secondary rounded-pill">
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
