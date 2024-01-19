@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3>Publicaci&oacute;n</h3>
            <div class="col-md-12 mt-5">
                @foreach ($publicacion as $item)
                    <div class="card col-md-4">
                        @if ($item->rutaImagen != 'none.png')
                            <img src="{{ asset('img/publicaciones/' . $item->rutaImagen) }}" class="card-img-top"
                                alt="ad-image" style="max-width: 100%; max-height: 200px; margin: 5px px;">
                        @else
                            <img id="imagen-preview-editar" class="border rounded"
                                src="{{ asset('img/publicaciones/none.png') }}" alt="Vista previa de la imagen"
                                style="max-width: 100%; max-height: 200px; margin-top: 10px;">
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
