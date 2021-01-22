@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuesto')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="budget-form" class="form" method="POST" action="{{ route('budget.create.step.four') }}" enctype="multipart/form-data">
            @csrf

            @if( Session::has('flash_message') )
              <div class="alert {{ Session::get('flash_type') }} alert-dismissible fade show" role="alert">
                {{ Session::get('flash_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="card">
              <div class="card-header card-header-info">
                <h4 class="card-title ">{{ __('Matricula: ') }} {{ session()->get('car')->plate ?? '' }}</h4>
                <p class="card-category">{{ __('Presupuesto/vehículo: ') }} </p>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col">
                    <label for="plate">Matricula</label>
                    <input type="text" name="plate" class="form-control" value="{{ $car->plate }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="brand">Marca</label>
                    <input type="text" name="brand" class="form-control" value="{{ $car->brand }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="model">Modelo</label>
                    <input type="text" name="model" class="form-control" value="{{ $car->model }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="color">Color</label>
                    <input type="text" name="color" class="form-control" value="{{ $car->color }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="year">Año</label>
                    <input type="text" name="year" class="form-control" value="{{ $car->year }}" readonly="">
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="client_id">Cliente</label>
                    <input type="hidden" name="client_id" class="form-control" value="{{ $params->client_id }}">
                    <input type="text" name="client" class="form-control" value="{{ \App\Client::where('id',$params->client_id)->first()->name }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="perito">Perito</label>
                    <input type="hidden" name="perito_id" class="form-control" value="{{ $params->perito_id }}">
                    <input type="text" name="perito" class="form-control" value="{{ \App\User::where('id',$params->perito_id)->first()->name ?? '' }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="technical">Técnico</label>
                    <input type="hidden" name="technical_id" class="form-control" value="{{ $params->technical_id }}">
                    <input type="text" name="technical" class="form-control" value="{{ \App\User::where('id',$params->technical_id)->first()->name ?? '' }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="tarifa">Tarifa PDR</label>
                    <input id="tarifa_pdr" type="number" name="tarifa" class="form-control" value="5">
                  </div>
                  <div class="col">
                    <label for="cia">CIA</label>
                    <input id="cia" type="text" name="cia" class="form-control">
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="boss_id">Encargado taller</label>
                    <input type="hidden" name="boss_id" class="form-control" value="{{ $params->boss_id }}">
                    <input type="text" name="client" class="form-control" value="{{ $params->boss_id ? \App\User::where('id',$params->boss_id)->first()->name : '' }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="iva">Porcentaje de IVA</label>
                    <input id="iva_rate" type="text" name="iva" class="form-control" value="21">
                  </div>
                  <div class="col">
                    <label for="currency">Porcentaje de IVA</label>
                    <select id="select-currency" type="text" name="currency" class="form-control">
                      <option value="USD" nombre="Dolar">Dolar</option>
                      <option value="EUR" nombre="Euros">Euros</option>
                      <option value="ARS" nombre="Pesos">Pesos</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="public_comment">Comentario para cliente</label>
                    <textarea id="public_comment" type="number" name="public_comment" class="form-control"></textarea>
                  </div>
                  <div class="col">
                    <label for="private_comment">Comentario para Andanar</label>
                    <textarea id="private_comment" type="number" name="private_comment" class="form-control"></textarea>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col">
                    <label for="files">Adjunto 1</label>
                    <input id="files1" type="file" name="file[]" class="form-control adjuntos"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 2</label>
                    <input id="files2" type="file" name="file[]" class="form-control adjuntos"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 3</label>
                    <input id="files3" type="file" name="file[]" class="form-control adjuntos"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 4</label>
                    <input id="files4" type="file" name="file[]" class="form-control adjuntos"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 5</label>
                    <input id="files5" type="file" name="file[]" class="form-control adjuntos"/>
                  </div>
                </div>

                <div class="row mt-3">

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 15%">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="8" part="Aleta del der" abpart="ADD" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/top 1.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="9" part="Puerta del der" abpart="PDD" style="float: left;width: 17%">
                      <img src="{{ asset('images/car_graph/top 2.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="10" part="Puerta tra der" abpart="PTD" style="float: left;width: 14%">
                      <img src="{{ asset('images/car_graph/top 3.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="12" part="Aleta tra der" abpart="ATD" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/top 4.png') }}" alt="">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 21%">
                    </div>
                    <!-- <div class="col hover-custom" style="float: left;width: 8%">
                      <img src="{{ asset('images/car_graph/adelante.png') }}" alt="">
                    </div> -->
                    <div class="col hover-custom add-item-budget" part="Capot" numrowpart="0" abpart="CAPOT" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/mid 1.png') }}" alt="">
                    </div>
                    <div class="col" style="float: left;width: 20%">
                      <img class="hover-custom add-item-budget" part="Montante derecho" numrowpart="11" abpart="MD" src="{{ asset('images/car_graph/mid 4.png') }}" alt="">
                      <img class="hover-custom add-item-budget" part="Techo" numrowpart="1" abpart="TECHO" src="{{ asset('images/car_graph/mid 2.png') }}" alt="">
                      <img class="hover-custom add-item-budget" part="Montante izquierdo" numrowpart="6" abpart="MI" src="{{ asset('images/car_graph/mid 5.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Maletero" numrowpart="2" abpart="MALETERO" style="float: left;width: 16%">
                      <img src="{{ asset('images/car_graph/mid 3.png') }}" alt="">
                    </div>
                    <!-- <div class="col hover-custom" style="float: left;width: 9%">
                      <img src="{{ asset('images/car_graph/atras.png') }}" alt="">
                    </div> -->
                  </div>

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 15%">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="3" part="Aleta del izq" abpart="ADI" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/bot 1.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="4" part="Puerta del izq" abpart="PDI" style="float: left;width: 17%">
                      <img src="{{ asset('images/car_graph/bot 2.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="5" part="Puerta tra izq" abpart="PTI" style="float: left;width: 14%">
                      <img src="{{ asset('images/car_graph/bot 3.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" numrowpart="7" part="Aleta del izq" abpart="ATI" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/bot 4.png') }}" alt="">
                    </div>
                  </div>  
                </div>

                <div class="row">
                  <div class="col-md-12" id="items-budget">
                    <div class="form-row mt-3">
                      <div class="text-center btn-primary" style="width: 13.63%;">
                        <strong>
                          Plano
                        </strong>
                      </div>
                      <div class="text-center btn-warning" style="width: 3%;">
                        <strong>
                          AL
                        </strong>
                      </div>
                      <div class="col-md-4 text-center btn-info">
                        <strong>
                          Dimensiones
                        </strong>
                      </div>
                      <div class="col-md-4 text-center btn-success">
                        <strong>
                          VD's
                        </strong>
                      </div>
                      <div class="col-md-1 text-center btn-danger">
                        <strong>
                          Total VD's
                        </strong>
                      </div>
                      <div class="col-md-1 text-center btn-success">
                        <strong id="total-currency">
                          Total
                        </strong>
                      </div>
                    </div>
                    <div class="form-row text-center">
                      <div class="col-md-2"></div>
                      <div class="col-md-1 btn-info">2cm</div>
                      <div class="col-md-1 btn-info">3cm</div>
                      <div class="col-md-1 btn-info">5cm</div>
                      <div class="col-md-1 btn-info">P/P</div>
                      <div class="col-md-1 btn-success">2cm</div>
                      <div class="col-md-1 btn-success">3cm</div>
                      <div class="col-md-1 btn-success">5cm</div>
                      <div class="col-md-1 btn-success">P/P</div>
                      <div class="col-md-2"></div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="0">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">CAPÓ</span>
                          <span class="subtitle-size minor-height">hood/capot</span>
                          <input class="form-control" type="hidden" name="part[]" value="CAPOT">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <input class="form-control" type="hidden" autocomplete="off" name="material[]">
                        <p class="text-center text-material0"></p>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="0" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow0" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="1">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">TECHO</span>
                          <span class="subtitle-size minor-height">roof/toit</span>
                          <input class="form-control" type="hidden" name="part[]" value="TECHO">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <input class="form-control text-center" type="hidden" autocomplete="off" name="material[]">
                        <p class="text-center text-material1"></p>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="1" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow1" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="2">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MALETERO</span>
                          <span class="subtitle-size minor-height">trunk/coffre</span>
                          <input class="form-control" type="hidden" name="part[]" value="MALETERO">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material2"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="2" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow2" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1">
                      <div class="col">
                        <span class="bmd-form-group is-filled center-flex">
                          Lateral izquierdo / left side / coté gouché
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="3">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Del. Izq.</span>
                          <span class="subtitle-size minor-height">left front wing/aile AVG</span>
                          <input class="form-control" type="hidden" name="part[]" value="ADI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material3"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="3" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow3" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="4">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Del. Izq.</span>
                          <span class="subtitle-size minor-height">left front door/porte AVG</span>
                          <input class="form-control" type="hidden" name="part[]" value="PDI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material4"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="4" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow4" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="5">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Tras. Izq.</span>
                          <span class="subtitle-size minor-height">left rear door/porte ARG</span>
                          <input class="form-control" type="hidden" name="part[]" value="PTI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material5"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="5" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow5" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="6">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MONTANTE Izq.</span>
                          <span class="subtitle-size minor-height">left rail/brancard G</span>
                          <input class="form-control" type="hidden" name="part[]" value="MI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material6"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="6" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow6" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="7">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Tras. Izq.</span>
                          <span class="subtitle-size minor-height">left rear wing/aile ARG</span>
                          <input class="form-control" type="hidden" name="part[]" value="ATI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material7"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="7" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow7" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1">
                      <div class="col">
                        <span class="bmd-form-group is-filled center-flex">
                          Lateral derecho / right side / coté droit
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="8">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Del. Der.</span>
                          <span class="subtitle-size minor-height">right front wing/aile AVD</span>
                          <input class="form-control" type="hidden" name="part[]" value="ADD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material8"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="8" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow8" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="9">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERETA Del. Der.</span>
                          <span class="subtitle-size minor-height">right front door/porte AVD</span>
                          <input class="form-control" type="hidden" name="part[]" value="PDD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material9"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="9" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow9" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="10">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Tras. Der.</span>
                          <span class="subtitle-size minor-height">right rear door/porte ARD</span>
                          <input class="form-control" type="hidden" name="part[]" value="PTD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material10"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="10" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow10" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="11">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MONTANTE Der.</span>
                          <span class="subtitle-size minor-height">right rail/brancard D</span>
                          <input class="form-control" type="hidden" name="part[]" value="MD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material11"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="11" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow11" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    <div class="form-row mt-1 hover-rows no-to-send" numrow="12">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Tras. Der.</span>
                          <span class="subtitle-size minor-height">right rear wing/aile ARD</span>
                          <input class="form-control" type="hidden" name="part[]" value="ATD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]">
                          <p class="text-center text-material12"></p>
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDS" type="number" value="0" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDM" type="number" value="0" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDB" type="number" value="0" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumDP" type="number" value="0" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDS" type="number" value="0" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDM" type="number" value="0" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDB" type="number" value="0" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text sumVDP" type="number" value="0" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control hidden-text totalrow" num="12" type="number" value="0" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-md-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow12" class="form-control hidden-text totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-row text-center mt-3">
                      
                      <div class="col-md-3"></div>

                      <div class="col-md-2">Ajuste manual:</div>
                      <div class="col-md-1">
                        <input id="manual-check" type="checkbox" name="manual_check">
                      </div>
                      <div class="col-md-2">
                        <input id="manual-total" type="number" min="0" value="0" style="width: 100%;" disabled="">
                      </div>

                      
                      <div class="col-md-2">
                        Des/Montaje
                      </div>
                      <div class="col-md-2">
                        <input id="desmontaje" name="desmontaje" type="number" min="0" value="0" style="width: 100%;">
                      </div>

                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-row text-center mt-3">
                      <div class="col-md-2">IVA:</div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1"></div>
                      <div class="col-md-1 btn-success total_iva"></div>
                      <input id="iva_total" name="iva_total" type="hidden" value="0">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-row text-center">
                      <div class="col-md-2">Totales:</div>
                      <div class="col-md-1 btn-info totalDS"></div>
                      <div class="col-md-1 btn-info totalDM"></div>
                      <div class="col-md-1 btn-info totalDB"></div>
                      <div class="col-md-1 btn-info totalDP"></div>
                      <div class="col-md-1 btn-success totalVDS"></div>
                      <div class="col-md-1 btn-success totalVDM"></div>
                      <div class="col-md-1 btn-success totalVDB"></div>
                      <div class="col-md-1 btn-success totalVDP"></div>
                      <div class="col-md-1 btn-danger totalVD"></div>
                      <div class="col-md-1 btn-success totalEUR"></div>
                      <input id="grand_total" name="grand_total" type="hidden" value="0">
                    </div>
                  </div>
                </div>

              </div>

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-info">{{ __('Guardar') }}</button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="myModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col text-center">
              <input type="checkbox" name="material" id="materialcheck" material="Hierro" data-label-text="Cambiar" data-on-color="success" data-off-color="info" autocomplete="off">
            </div>
          </div>
          <h6>Tamaños de las abolladuras</h6>
          <div class="form-row">
            <div class="col text-center">
              <span>2cm</span>
            </div>
            <div class="col text-center">
              <span>3cm</span>
            </div>
            <div class="col text-center">
              <span>5cm</span>
            </div>
            <div class="col text-center">
              <span>P/P</span>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <input id="small_size" type="number" class="form-control" value="0">
            </div>
            <div class="col">
              <input id="medium_size" type="number" class="form-control" value="0">
            </div>
            <div class="col">
              <input id="big_size" type="number" class="form-control" value="0">
            </div>
            <div class="col">
              <input id="to_paint" type="number" class="form-control" value="0">
            </div>
          </div>
        </div>
        <input type="hidden" id="add-part">
        <input type="hidden" id="numrow-toadd">
        <div class="modal-footer">
          <button type="button" class="btn btn-primary add-row">Agregar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('inlinejs')
  <script src="{{ asset('js/selectize.js') }}"></script>
  <script src="{{ asset('js/bootstrap-switch.js') }}"></script>
  <script>
    $(document).ready( function () {
      var rows = 0;
      $('#manual-check').change(function() {
        if ( this.checked ) {
          $('#manual-total').attr('disabled', false);
          
          var total = parseFloat($('#manual-total').val());
          $('.totalEUR').html('');
          var iva = parseFloat($('#iva_rate').val()) / 100;

          var desmontaje = isNaN( $('#desmontaje').val() ) ? 0 : parseFloat($('#desmontaje').val());
          total += desmontaje;

          var iva_total = total * iva;
          var total_con_iva = total + iva_total;

          var result_iva = parseFloat(iva_total).toFixed(2);
          var result_total = parseFloat(total_con_iva).toFixed(2);

          result_iva = isNaN(result_iva) ? 0 : result_iva;
          result_total = isNaN(result_total) ? 0 : result_total;

          $('#iva_total').val( result_iva );
          $('.total_iva').html( result_iva );
          $('#grand_total').val( result_total );
          $('.totalEUR').html( result_total );

        }
        if ( !this.checked ) {
          $('#manual-total').attr('disabled', true);
          $('#manual-total').val(0);
          calculateTotals();
        }
      });

      $('#manual-total').on('input', function(e){
        var total = parseFloat($(this).val());
        $('.totalEUR').html('');
        var iva = parseFloat($('#iva_rate').val()) / 100;

        var desmontaje = isNaN( $('#desmontaje').val() ) ? 0 : parseFloat($('#desmontaje').val());
        total += desmontaje;

        var iva_total = total * iva;
        var total_con_iva = total + iva_total;

        var result_iva = parseFloat(iva_total).toFixed(2);
        var result_total = parseFloat(total_con_iva).toFixed(2);

        result_iva = isNaN(result_iva) ? 0 : result_iva;
        result_total = isNaN(result_total) ? 0 : result_total;

        $('#iva_total').val( result_iva );
        $('.total_iva').html( result_iva );
        $('#grand_total').val( result_total );
        $('.totalEUR').html( result_total );
      });

      $('#desmontaje').on('input', function(e){
        var val = $(this).val() === "" ? 0 : $(this).val();
        if ( !$('#manual-check').prop('checked') ) {
          calculateTotals();
          return true;
        }

        var total = parseFloat($('#manual-total').val());
        var iva = parseFloat($('#iva_rate').val()) / 100;
        
        total += parseFloat(val);
        
        var iva_total = total * iva;
        var total_con_iva = total + iva_total;

        var result_iva = parseFloat(iva_total).toFixed(2);
        var result_total = parseFloat(total_con_iva).toFixed(2);

        result_iva = isNaN(result_iva) ? 0 : result_iva;
        result_total = isNaN(result_total) ? 0 : result_total;

        $('#iva_total').val( result_iva );
        $('.total_iva').html( result_iva );
        $('#grand_total').val( result_total );
        $('.totalEUR').html( result_total );
      });

      // Boton para agregar ya la fila
      $('.add-row').on('click', function(e){
        
        if ( $('#tarifa_pdr').val() === '' ) {
          alert('Debe ingresar una tarifa antes de agregar elementos al presupuesto');
          return false;
        }

        var qtySmall = 0;
        var s = parseInt( $('#small_size').val() );
        var m = parseInt( $('#medium_size').val() );
        var b = parseInt( $('#big_size').val() );
        var p = parseInt( $('#to_paint').val() );

        var numrow = $('#numrow-toadd').val();
        $($('[numrow='+numrow+'] input')[2]).val(s);
        $($('[numrow='+numrow+'] input')[2]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[3]).val(m);
        $($('[numrow='+numrow+'] input')[3]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[4]).val(b);
        $($('[numrow='+numrow+'] input')[4]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[5]).val(p);
        $($('[numrow='+numrow+'] input')[5]).removeClass('hidden-text');

        if ((s <= 0) && (m <= 0) && (b <= 0) && (p <= 0)) { return 0;}

        if ( s <= 0 )                         { sVD = 0;}
        else if ( (s >= 1) && (s <= 2) )      { sVD = 4;}
        else if ( (s >= 3) && (s <= 5) )      { sVD = 8;}
        else if ( (s >= 6) && (s <= 10) )     { sVD = 12;}
        else if ( (s >= 11) && (s <= 20) )    { sVD = 18;}
        else if ( (s >= 21) && (s <= 30) )    { sVD = 24;}
        else if ( (s >= 31) && (s <= 50) )    { sVD = 30;}
        else if ( (s >= 51) && (s <= 70) )    { sVD = 40;}
        else if ( (s >= 71) && (s <= 100) )   { sVD = 50;}
        else if ( (s >= 101) && (s <= 130) )  { sVD = 60;}
        else if ( (s >= 131) && (s <= 180) )  { sVD = 70;}
        else if ( (s >= 181) && (s <= 250) )  { sVD = 80;}
        else if ( s > 250 )                   { sVD = 100;}

        if ( m <= 0 )                       { mVD = 0;}
        else if ( (m >= 1) && (m <= 2) )    { mVD = 8;}
        else if ( (m >= 3) && (m <= 5) )    { mVD = 12;}
        else if ( (m >= 6) && (m <= 10) )   { mVD = 16;}
        else if ( (m >= 11) && (m <= 15) )  { mVD = 20;}
        else if ( (m >= 16) && (m <= 20) )  { mVD = 26;}
        else if ( (m >= 21) && (m <= 30) )  { mVD = 34;}
        else if ( (m >= 31) && (m <= 40) )  { mVD = 44;}
        else if ( (m >= 41) && (m <= 50) )  { mVD = 52;}
        else if ( (m >= 51) && (m <= 60) )  { mVD = 62;}
        else if ( (m >= 61) && (m <= 80) )  { mVD = 72;}
        else if ( (m >= 80) && (m <= 100) ) { mVD = 84;}
        else if ( m > 100 )                 { mVD = 100;}

        if ( b <= 0 )                       { bVD = 0;}
        else if ( (b >= 1) && (b <= 2) )    { bVD = 12;}
        else if ( (b >= 3) && (b <= 5) )    { bVD = 18;}
        else if ( (b >= 6) && (b <= 10) )   { bVD = 24;}
        else if ( (b >= 11) && (b <= 15) )  { bVD = 30;}
        else if ( (b >= 16) && (b <= 20) )  { bVD = 39;}
        else if ( (b >= 21) && (b <= 30) )  { bVD = 51;}
        else if ( (b >= 31) && (b <= 40) )  { bVD = 66;}
        else if ( (b >= 41) && (b <= 50) )  { bVD = 78;}
        else if ( (b >= 51) && (b <= 60) )  { bVD = 93;}
        else if ( (b >= 61) && (b <= 80) )  { bVD = 108;}
        else if ( (b >= 80) && (b <= 100) ) { bVD = 126;}
        else if ( b > 100 )                 { bVD = 150;}

        if ( p <= 0 )                       { pVD = 0;}
        else if ( (p >= 1) && (p <= 2) )    { pVD = 8;}
        else if ( (p >= 3) && (p <= 5) )    { pVD = 13;}
        else if ( (p >= 6) && (p <= 10) )   { pVD = 17;}
        else if ( (p >= 11) && (p <= 15) )  { pVD = 21;}
        else if ( (p >= 16) && (p <= 20) )  { pVD = 27;}
        else if ( (p >= 21) && (p <= 30) )  { pVD = 36;}
        else if ( (p >= 31) && (p <= 40) )  { pVD = 46;}
        else if ( (p >= 41) && (p <= 50) )  { pVD = 55;}
        else if ( (p >= 51) && (p <= 60) )  { pVD = 65;}
        else if ( (p >= 61) && (p <= 80) )  { pVD = 76;}
        else if ( (p >= 81) && (p <= 100) ) { pVD = 88;}
        else if ( p > 100 )                 { pVD = 105;}

        mat = 'Hierro';
        $('.text-material'+numrow).html('');
        if ( $('#materialcheck').attr('material') == 'Aluminio') {
          mat = 'Aluminio';
          $('.text-material'+numrow).html('x');
          sVD = parseInt(sVD + (sVD * 0.2));
          mVD = parseInt(mVD + (mVD * 0.2));
          bVD = parseInt(bVD + (bVD * 0.2));
          pVD = parseInt(pVD + (pVD * 0.2));
        }
        
        $($('[numrow='+numrow+'] input')[1]).val(mat);
        $($('[numrow='+numrow+'] input')[1]).removeClass('hidden-text');

        $($('[numrow='+numrow+'] input')[6]).val(sVD);
        $($('[numrow='+numrow+'] input')[6]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[7]).val(mVD);
        $($('[numrow='+numrow+'] input')[7]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[8]).val(bVD);
        $($('[numrow='+numrow+'] input')[8]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[9]).val(pVD);
        $($('[numrow='+numrow+'] input')[9]).removeClass('hidden-text');

        let totalVDs = sVD+mVD+bVD+pVD;
        let totalEur = totalVDs * parseInt($('#tarifa_pdr').val());
        $($('[numrow='+numrow+'] input')[10]).val(totalVDs);
        $($('[numrow='+numrow+'] input')[10]).removeClass('hidden-text');
        $($('[numrow='+numrow+'] input')[11]).val(totalEur);
        $($('[numrow='+numrow+'] input')[11]).removeClass('hidden-text');

        $($('[numrow='+numrow+']')).addClass('item-row-active');
        $($('[numrow='+numrow+']')).removeClass('no-to-send');

        $('#small_size').val(0);
        $('#medium_size').val(0);
        $('#big_size').val(0);
        $('#to_paint').val(0);

        // Iniciacion del toogle de los mataeriales
        $('#materialcheck').bootstrapSwitch('state', false);

        calculateTotals();
        $('#myModal').modal('hide');
      });
      
      $(document).on('click', '.hover-rows', function(e){
        $(this).removeClass('item-row-active');
        $(this).addClass('no-to-send');
        $(this).find(':input').each(function(){
          $(this).val(0);
          $(this).addClass('hidden-text');
        });
        $(this).find('p').each(function(){
          $(this).html('');
        });
        calculateTotals();
      });

      $('#tarifa_pdr').on('input', function(e){
        if ( !$('#manual-check').prop('checked') ) {
          var tarifa = $(this).val();
          if (tarifa === "") {
            alert('Debe ingresar una tarifa');
            return false;
          }
          if (parseFloat(tarifa) <= 0) {
            alert('La tarifa debe ser mayor a 0');
            return false; 
          }
          calculateTotals();
        }
      });

      function calculateRate() {
        if ( !$('#manual-check').prop('checked') ) {
          var tarifa = parseInt( $('#tarifa_pdr').val() );
          $('.totalrow').each(function(){
            var num = $(this).attr('num');
            var val = $(this).val();
            $('#totalMoneyRow'+num).val( (val * tarifa) );
          });
        }
      }

      function calculateManual() {
        var total = parseFloat( $('#manual-total').val() );
        $('.totalEUR').html('');

        var iva = parseFloat( $('#iva_rate').val() ) / 100;

        var desmontaje = ( $('#desmontaje').val() === "" ) ? 0 : parseFloat( $('#desmontaje').val() );
        total += desmontaje;

        var iva_total = total * iva;
        var total_con_iva = total + iva_total;

        var result_iva = parseFloat(iva_total).toFixed(2);
        var result_total = parseFloat(total_con_iva).toFixed(2);

        result_iva = isNaN(result_iva) ? 0 : result_iva;
        result_total = isNaN(result_total) ? 0 : result_total;

        $('#iva_total').val( result_iva );
        $('.total_iva').html( result_iva );
        $('#grand_total').val( result_total );
        $('.totalEUR').html( result_total );
      }

      function calculateTotals(){
        var X = 0;
        $('.sumDS').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalDS').html('');
        $('.totalDS').html(parseInt(X));

        X = 0;
        $('.sumDM').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalDM').html('');
        $('.totalDM').html(parseInt(X));

        X = 0;
        $('.sumDB').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalDB').html('');
        $('.totalDB').html(parseInt(X));

        X = 0;
        $('.sumDP').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalDP').html('');
        $('.totalDP').html(parseInt(X));

        X = 0;
        $('.sumVDS').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalVDS').html('');
        $('.totalVDS').html(parseInt(X));

        X = 0;
        $('.sumVDM').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalVDM').html('');
        $('.totalVDM').html(parseInt(X));

        X = 0;
        $('.sumVDB').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalVDB').html('');
        $('.totalVDB').html(parseInt(X));

        X = 0;
        $('.sumVDP').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalVDP').html('');
        $('.totalVDP').html(parseInt(X));

        X = 0;
        $('.totalrow').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalVD').html('');
        $('.totalVD').html(parseInt(X));

        calculateRate();

        X = 0;
        $('.totalMoneyRow').each(function(){
          X += parseInt($(this).val());
        });

        $('.totalEUR').html('');
        var iva = parseFloat($('#iva_rate').val()) / 100;
        var desmontaje = $('#desmontaje').val() == "" ? parseFloat(0) : parseFloat($('#desmontaje').val());

        X += desmontaje;

        var iva_total = X * iva;
        var total_con_iva = X + iva_total;

        var result_iva = parseFloat(iva_total).toFixed(2);
        var result_total = parseFloat(total_con_iva).toFixed(2);

        result_iva = isNaN(result_iva) ? 0 : result_iva;
        result_total = isNaN(result_total) ? 0 : result_total;

        $('#iva_total').val( result_iva );
        $('.total_iva').html( result_iva );
        $('#grand_total').val( result_total );
        $('.totalEUR').html( result_total );
      }

      // Iniciacion del toogle de los mataeriales
      $('#materialcheck').bootstrapSwitch();
      $('#materialcheck').bootstrapSwitch('onText', 'Aluminio');
      $('#materialcheck').bootstrapSwitch('offText', 'Hierro');
      // Funcion cuando cambia el toogle del material Aluminio/Hierro
      $('#materialcheck').bootstrapSwitch('onSwitchChange', function(event, state) {
        if (state) {
          $('#materialcheck').attr('material','Aluminio');
        }
        if (!state) {
          $('#materialcheck').attr('material','Hierro');
        }
      });

      // Cuando se selecciona una parte del carro
      $('.add-item-budget').on('click', function(e) {
        $('.modal-title').html( $(this).attr('part') );
        $('#numrow-toadd').val( $(this).attr('numrowpart') );
        $('#add-part').val( $(this).attr('abpart') );
        $('#myModal').modal('show');
      });

      $('#select-client').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        },
        dropdownParent: 'body',
        persist: true
      });
      $('#select-perito').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        },
        dropdownParent: 'body',
        persist: true
      });
      $('#select-technical').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        },
        dropdownParent: 'body',
        persist: true
      });

      $('#select-brand').on('change', function(e){
        if ( $(this).val() ) {
          const models_url = '/cars/' + $(this).val() + '/models';
          $.ajax({
            url: models_url,
            success: function(response) {
             $('#select-model').selectize()[0].selectize.destroy();
              $('#select-model').empty();
              $('#select-model').append(response);
              $('#select-model').selectize({
                create: false,
                sortField: {
                  field: 'text',
                  direction: 'asc'
                },
                dropdownParent: 'body'
              });
            }
          });
        } else {
          $('#select-model').selectize()[0].selectize.destroy();
          $('#select-model').empty();
          $('#select-model').append('<option value=""></option>');
          $('#select-model').selectize({
            create: false,
            sortField: {
              field: 'text',
              direction: 'asc'
            },
            dropdownParent: 'body'
          });
        }
      });

      $('#select-currency').on('change', function(e){
        var obj = $("#select-currency option:selected");
        $('#total-currency').html( 'Total ' + obj.text() );
      });

      $('#budget-form').on('submit', function(e){
        $('.no-to-send').remove();
        if ( $('#manual-check').prop('checked') ) {
          $('#tarifa_pdr').val(0);
        }
      });
    });
  </script>
@endsection