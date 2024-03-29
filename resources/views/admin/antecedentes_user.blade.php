@extends('adminlte::page')

@section('title', 'Antecedentes Medicos')

@section('content')
    <div class="container">
        {{-- Mostrar aqui los antecedentes junto a la info del paciente --}}
        <h1 class="pt-3">Antecedente M&eacute;dico</h1>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                @if (count($antecedentesMedicos) == 0)
                    <div class="card">
                        <div class="card-body bg-danger rounded">
                            <h3 class="text-uppercase text-center">NO SE HAN REGISTRADO ANTECEDENTES PARA ESTE PACIENTE</h3>
                        </div>
                    </div>
                @else
                @endif
                @foreach ($antecedentesMedicos as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="information">
                                <form class="form-floating">
                                    <div class="row">
                                        <label for="created_date"
                                            class="text-end text-danger">Creado:&nbsp;{{ $item->created_at }}</label>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Nombres</label>
                                            <input type="text" class="form-control" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->paciente->nombres }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Apellidos</label>
                                            <input type="text" class="form-control" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->paciente->apellidos }} ">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Hipertencion Arterial</label><br>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->hipertencionArterial == '1' ? 'Si' : 'No' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Cardiopatia</label>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" disabled
                                                value="{{ $item->cardiopatia == '1' ? 'Si' : 'No' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Diabetes Mellitu</label><br>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->diabetesMellitu == '1' ? 'Si' : 'No' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Problema Renal</label>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->problemaRenal == '1' ? 'Si' : 'No' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Problema Respiratorio</label><br>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->problemaRespiratorio == '1' ? 'Si' : 'No' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Problema Hep&aacute;tico</label>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->problemaHepatico == '1' ? 'Si' : 'No' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Problema Endocrino</label><br>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->problemaEndocrino == '1' ? 'Si' : 'No' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Problema Hemorragico</label>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->problemaHemorragico == '1' ? 'Si' : 'No' }}">
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6">
                                            <label for="floatingInputInvalid">Embarazo</label>
                                            <input type="text" class="form-control col-8 text-center" @readonly(true)
                                                id="floatingInputInvalid" @disabled(true)
                                                value="{{ $item->embarazo == '1' ? 'Si' : 'No' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="otrosMedicamentosQueToma" class="">Alergia a
                                                Medicamentos</label>
                                            <textarea type="text" class="form-control" @disabled(true) id="otrosMedicamentosQueToma"
                                                name="otrosMedicamentosQueToma" rows="3" @readonly(true) maxlength="255">{{ $item->alergiaMedicamentos == '' ? '--Sin observacion--' : $item->alergiaMedicamentos }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6">
                                            <label for="otrosMedicamentosQueToma" class="">Otros medicamentos que
                                                toma</label>
                                            <textarea type="text" class="form-control" @disabled(true) id="otrosMedicamentosQueToma"
                                                name="otrosMedicamentosQueToma" rows="3" @readonly(true) maxlength="255">{{ $item->otrosMedicamentosQueToma == '' ? '--Sin observacion--' : $item->otrosMedicamentosQueToma }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="otrosMedicamentosQueToma" class="">Datos Adicionales</label>
                                            <textarea type="text" class="form-control" @disabled(true) id="otrosMedicamentosQueToma"
                                                name="otrosMedicamentosQueToma" rows="3" @readonly(true) maxlength="255">{{ $item->otrosDatos == '' ? '--Sin observacion--' : $item->otrosDatos }}</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
