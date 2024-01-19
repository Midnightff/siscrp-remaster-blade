@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3>Publicaci&oacute;n</h3>
            <div class="col-md-12 mt-5">
                @foreach ($publicacion as $item)
                    <div class="card" style="width: 18rem;">
                        @if ($item->rutaImagen)
                        <img src="{{ URL::to('img/publicaciones/' . $item->rutaImagen) }}" class="card-img-top" alt="...">
                        @else
                            Sin Imagen
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->titulo }}</h5>
                            <p class="card-text">{{ $item->descripcion }}</p>
                            <p class="card-text text-secondary">$&nbsp;{{ $item->precio }}</p>
                            <p class="card-text"><small
                                    class="text-body-secondary">Del:&nbsp;{{ $item->fechaInicio }}&nbsp;Al:&nbsp;{{ $item->fechaFinal }}</small>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
