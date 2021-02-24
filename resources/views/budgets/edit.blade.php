@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuesto')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <form id="budget-form" class="form" method="POST" action="{{ route('budget.update', $budget->id) }}" enctype="multipart/form-data">
            @method('PUT')
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
                <h4 class="card-title ">{{ __('Matricula: ') }} {{ $budget->car->plate ?? '' }}</h4>
                <p class="card-category">{{ __('Presupuesto/vehículo: ') }} </p>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col">
                    <label for="plate">Matricula</label>
                    <input type="text" name="plate" class="form-control" value="{{ $budget->car->plate }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="brand">Marca</label>
                    <input type="text" name="brand" class="form-control" value="{{ $budget->car->brand }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="model">Modelo</label>
                    <input type="text" name="model" class="form-control" value="{{ $budget->car->model }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="color">Color</label>
                    <input type="text" name="color" class="form-control" value="{{ $budget->car->color }}" readonly="">
                  </div>
                  <div class="col">
                    <label for="year">Año</label>
                    <input type="text" name="year" class="form-control" value="{{ $budget->car->year }}" readonly="">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <label for="client_id">Cliente</label>
                    <select name="client_id" id="select-client" required="" autocomplete="off">
                      @foreach( \App\Client::all() as $client)
                        <option value="{{ $client->id }}" @if($budget->isClient($client->id)) selected @endif>
                          {{ $client->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <label for="perito">Perito</label>
                    <select name="proficient_id" id="select-perito" autocomplete="off">
                      <option value=""></option>
                      @foreach( \App\User::where('type','proficient')->where('status',1)->get() as $proficient)
                        <option value="{{ $proficient->id }}" @if($budget->isPerito($proficient->id)) selected @endif>
                          {{ $proficient->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <label for="technical">Técnico</label>
                    <select name="technical_id" id="select-technical" autocomplete="off">
                      <option value=""></option>
                      @foreach( \App\User::where('type','technical')->where('status',1)->get() as $technical)
                        <option value="{{ $technical->id }}" @if($budget->isTechnical($technical->id)) selected @endif>
                          {{ $technical->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <label for="tarifa">Tarifa PDR</label>
                    <input id="tarifa_pdr" type="number" name="tarifa" class="form-control" value="{{ $budget->tarifa_pdr }}">
                  </div>
                  <div class="col">
                    <label for="cia">CIA</label>
                    <input id="cia" type="text" name="cia" class="form-control" value="{{ $budget->cia_sure }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <label for="boss_id">Responsable taller</label>
                    <select name="boss_id" id="select-boss" autocomplete="off">
                      <option value=""></option>
                      @foreach( \App\User::where('type','boss')->where('status',1)->get() as $boss)
                        <option value="{{ $boss->id }}" @if($budget->isBoss($boss->id)) selected @endif>
                          {{ $boss->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <label for="iva">Porcentaje de IVA</label>
                    <input id="iva_rate" type="text" name="iva" class="form-control" value="{{ $budget->iva_rate }}">
                  </div>

                  <div class="col">
                    <label for="currency">Porcentaje de IVA</label>
                    <select id="select-currency" type="text" name="currency" class="form-control" autocomplete="off">
                      <option value="EUR" nombre="Euros" @if($budget->currency == 'EUR') selected="" @endif>
                        Euros
                      </option>
                      <option value="USD" nombre="Dolar" @if($budget->currency == 'USD') selected="" @endif>
                        Dolar
                      </option>
                      <option value="ARS" nombre="Pesos" @if($budget->currency == 'ARS') selected="" @endif>
                        Pesos
                      </option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="public_comment">Comentario para cliente</label>
                    <textarea id="public_comment" type="number" name="public_comment" class="form-control">{{ $budget->public_comment }}</textarea>
                  </div>
                  <div class="col">
                    <label for="private_comment">Comentario para {{ config('env_params.business_name') }}</label>
                    <textarea id="private_comment" type="number" name="private_comment" class="form-control">{{ $budget->private_comment }}</textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <label for="files">Adjunto 1</label>
                    <input id="files" type="file" name="file[]" class="form-control"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 2</label>
                    <input id="files" type="file" name="file[]" class="form-control"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 3</label>
                    <input id="files" type="file" name="file[]" class="form-control"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 4</label>
                    <input id="files" type="file" name="file[]" class="form-control"/>
                  </div>
                  <div class="col">
                    <label for="files">Adjunto 5</label>
                    <input id="files" type="file" name="file[]" class="form-control"/>
                  </div>
                </div>

                <div class="row mt-3">
                  <table>
                    <tr>
                      <td>
                          <img class="hover-custom add-item-budget piece-responsive" numrowpart="3" part="Aleta del izq" abpart="ADI" src="{{ asset('images/car_graph/top1.png') }}">
                      </td>  
                      <td colspan="3">
                          <img class="hover-custom add-item-budget piece-responsive" numrowpart="0" part="Capot" abpart="CAPOT" src="{{ asset('images/car_graph/top2.png') }}">
                      </td>
                      <td>
                          <img class="hover-custom add-item-budget piece-responsive" numrowpart="8" part="Aleta del der" abpart="ADD" src="{{ asset('images/car_graph/top3.png') }}">
                      </td>
                    </tr>
                  
                    <tr>
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="4" part="Puerta del izq" abpart="PDI" src="{{ asset('images/car_graph/midtop1.png') }}">
                      </td>
                      <td rowspan="2">
                        <img class="hover-custom add-item-budget piece-montante-responsive" numrowpart="6" part="Montante izquierdo" abpart="MI" src="{{ asset('images/car_graph/midcenter1.png') }}">
                      </td>
                      <td rowspan="2" style="padding: 0px;">
                        <img class="hover-custom add-item-budget piece-techo-responsive" numrowpart="1" part="Techo" abpart="TECHO" src="{{ asset('images/car_graph/midcenter2.png') }}" alt="">
                      </td>
                      <td rowspan="2">
                        <img class="hover-custom add-item-budget piece-montante-responsive" numrowpart="11" part="Montante derecho" abpart="MD" src="{{ asset('images/car_graph/midcenter3.png') }}">
                      </td>
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="9" part="Puerta del der" abpart="PDD"  src="{{ asset('images/car_graph/midtop2.png') }}">
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="5" part="Puerta tra izq" abpart="PTI" src="{{ asset('images/car_graph/midbotton1.png') }}">
                      </td>
                      
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="10" part="Puerta tra der" abpart="PTD" src="{{ asset('images/car_graph/midbotton2.png') }}">
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="7" part="Aleta del izq" abpart="ATI" src="{{ asset('images/car_graph/botton1.png') }}">
                      </td>
                      <td colspan="3">
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="2" part="Maletero" abpart="MALETERO" src="{{ asset('images/car_graph/botton2.png') }}">
                      </td>
                      <td>
                        <img class="hover-custom add-item-budget piece-responsive" numrowpart="12" part="Aleta tra der" abpart="ATD" src="{{ asset('images/car_graph/botton3.png') }}">
                      </td>
                    </tr>

                  </table>
                </div>

                <div class="row">
                  <div class="col-sm-12" id="items-budget">
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
                      <div class="col-sm-4 text-center btn-info">
                        <strong>
                          Dimensiones
                        </strong>
                      </div>
                      <div class="col-sm-4 text-center btn-success">
                        <strong>
                          VD's
                        </strong>
                      </div>
                      <div class="col-sm-1 text-center btn-danger">
                        <strong>
                          Total VD's
                        </strong>
                      </div>
                      <div class="col-sm-1 text-center btn-success">
                        <strong id="total-currency">
                          Total
                        </strong>
                      </div>
                    </div>
                    <div class="form-row text-center">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-1 btn-info">2cm</div>
                      <div class="col-sm-1 btn-info">3cm</div>
                      <div class="col-sm-1 btn-info">5cm</div>
                      <div class="col-sm-1 btn-info">P/P</div>
                      <div class="col-sm-1 btn-success">2cm</div>
                      <div class="col-sm-1 btn-success">3cm</div>
                      <div class="col-sm-1 btn-success">5cm</div>
                      <div class="col-sm-1 btn-success">P/P</div>
                      <div class="col-sm-2"></div>
                    </div>

                    @php
                      $b_items = $budget->items;
                      $capot = $b_items->where('part', 'CAPOT')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $capot ? 'item-row-active' : 'no-to-send' }}" numrow="0">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">CAPÓ</span>
                          <span class="subtitle-size minor-height">hood/capot</span>
                          <input class="form-control" type="hidden" name="part[]" value="CAPOT">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <input class="form-control" type="hidden" autocomplete="off" name="material[]" value="{{ $capot ? $capot->material : '' }}">
                        <p class="text-center text-material0">{{ $capot ? ($capot->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $capot ? $capot->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $capot ? $capot->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $capot ? $capot->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $capot ? $capot->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $capot ? $capot->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $capot ? $capot->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $capot ? $capot->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $capot ? $capot->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $capot ? '' : 'hidden-text' }} totalrow" num="0" type="number" value="{{ $capot ? $capot->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow0" class="form-control {{ $capot ? '' : 'hidden-text' }} totalMoneyRow" value="{{ $capot ? $capot->total_money : '' }}" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $techo = $b_items->where('part', 'TECHO')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $techo ? 'item-row-active' : 'no-to-send' }}" numrow="1">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">TECHO</span>
                          <span class="subtitle-size minor-height">roof/toit</span>
                          <input class="form-control" type="hidden" name="part[]" value="TECHO">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <input class="form-control text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $techo ? $techo->material : '' }}">
                        <p class="text-center text-material1">{{ $techo ? ($techo->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $techo ? $techo->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $techo ? $techo->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $techo ? $techo->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $techo ? $techo->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $techo ? $techo->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $techo ? $techo->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $techo ? $techo->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $techo ? $techo->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $techo ? '' : 'hidden-text' }} totalrow" num="1" type="number" value="{{ $techo ? $techo->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow1" class="form-control {{ $techo ? '' : 'hidden-text' }} totalMoneyRow" value="{{ $techo ? $techo->total_money : '' }}" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $maletero = $b_items->where('part', 'MALETERO')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $maletero ? 'item-row-active' : 'no-to-send' }}" numrow="2">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MALETERO</span>
                          <span class="subtitle-size minor-height">trunk/coffre</span>
                          <input class="form-control" type="hidden" name="part[]" value="MALETERO">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $maletero ? $maletero->material : '' }}">
                          <p class="text-center text-material2">{{ $maletero ? ($maletero->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $maletero ? $maletero->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $maletero ? $maletero->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $maletero ? $maletero->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $maletero ? $maletero->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $maletero ? $maletero->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $maletero ? $maletero->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $maletero ? $maletero->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $maletero ? $maletero->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $maletero ? '' : 'hidden-text' }} totalrow" num="2" type="number" value="{{ $maletero ? $maletero->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow2" class="form-control {{ $maletero ? '' : 'hidden-text' }} totalMoneyRow" value="{{ $maletero ? $maletero->total_money : '' }}" type="number" autocomplete="off" name="totalMoneyRow[]" readonly="">
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

                    @php
                      $ADIZQ = $b_items->where('part', 'ADI')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $ADIZQ ? 'item-row-active' : 'no-to-send' }}" numrow="3">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Del. Izq.</span>
                          <span class="subtitle-size minor-height">left front wing/aile AVG</span>
                          <input class="form-control" type="hidden" name="part[]" value="ADI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control hidden-text text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $ADIZQ ? $ADIZQ->material : '' }}">
                          <p class="text-center text-material3">{{ $ADIZQ ? ($ADIZQ->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $ADIZQ ? $ADIZQ->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $ADIZQ ? $ADIZQ->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $ADIZQ ? $ADIZQ->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $ADIZQ ? $ADIZQ->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $ADIZQ ? $ADIZQ->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $ADIZQ ? $ADIZQ->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $ADIZQ ? $ADIZQ->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $ADIZQ ? $ADIZQ->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} totalrow" num="3" type="number" value="{{ $ADIZQ ? $ADIZQ->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow3" class="form-control {{ $ADIZQ ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $ADIZQ ? $ADIZQ->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $PDIZQ = $b_items->where('part', 'PDI')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $PDIZQ ? 'item-row-active' : 'no-to-send' }}" numrow="4">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Del. Izq.</span>
                          <span class="subtitle-size minor-height">left front door/porte AVG</span>
                          <input class="form-control" type="hidden" name="part[]" value="PDI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $PDIZQ ? $PDIZQ->material : '' }}">
                          <p class="text-center text-material4">{{ $PDIZQ ? ($PDIZQ->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $PDIZQ ? $PDIZQ->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $PDIZQ ? $PDIZQ->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $PDIZQ ? $PDIZQ->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $PDIZQ ? $PDIZQ->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $PDIZQ ? $PDIZQ->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $PDIZQ ? $PDIZQ->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $PDIZQ ? $PDIZQ->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $PDIZQ ? $PDIZQ->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} totalrow" num="4" type="number" value="{{ $PDIZQ ? $PDIZQ->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow4" class="form-control {{ $PDIZQ ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $PDIZQ ? $PDIZQ->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $PTIZQ = $b_items->where('part', 'PTI')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $PTIZQ ? 'item-row-active' : 'no-to-send' }}" numrow="5">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Tras. Izq.</span>
                          <span class="subtitle-size minor-height">left rear door/porte ARG</span>
                          <input class="form-control" type="hidden" name="part[]" value="PTI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $PTIZQ ? $PTIZQ->material : '' }}">
                          <p class="text-center text-material5">{{ $PTIZQ ? ($PTIZQ->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $PTIZQ ? $PTIZQ->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $PTIZQ ? $PTIZQ->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $PTIZQ ? $PTIZQ->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $PTIZQ ? $PTIZQ->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $PTIZQ ? $PTIZQ->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $PTIZQ ? $PTIZQ->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $PTIZQ ? $PTIZQ->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $PTIZQ ? $PTIZQ->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} totalrow" num="5" type="number" value="{{ $PTIZQ ? $PTIZQ->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow5" class="form-control {{ $PTIZQ ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $PTIZQ ? $PTIZQ->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $MIZQ = $b_items->where('part', 'MI')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $MIZQ ? 'item-row-active' : 'no-to-send' }}" numrow="6">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MONTANTE Izq.</span>
                          <span class="subtitle-size minor-height">left rail/brancard G</span>
                          <input class="form-control" type="hidden" name="part[]" value="MI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $MIZQ ? $MIZQ->material : '' }}">
                          <p class="text-center text-material6">{{ $MIZQ ? ($MIZQ->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $MIZQ ? $MIZQ->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $MIZQ ? $MIZQ->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $MIZQ ? $MIZQ->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $MIZQ ? $MIZQ->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $MIZQ ? $MIZQ->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $MIZQ ? $MIZQ->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $MIZQ ? $MIZQ->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $MIZQ ? $MIZQ->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MIZQ ? '' : 'hidden-text' }} totalrow" num="6" type="number" value="{{ $MIZQ ? $MIZQ->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow6" class="form-control {{ $MIZQ ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $MIZQ ? $MIZQ->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $ATIZQ = $b_items->where('part', 'ATI')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $ATIZQ ? 'item-row-active' : 'no-to-send' }}" numrow="7">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Tras. Izq.</span>
                          <span class="subtitle-size minor-height">left rear wing/aile ARG</span>
                          <input class="form-control" type="hidden" name="part[]" value="ATI">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $ATIZQ ? $ATIZQ->material : '' }}">
                          <p class="text-center text-material7">{{ $ATIZQ ? ($ATIZQ->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $ATIZQ ? $ATIZQ->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $ATIZQ ? $ATIZQ->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $ATIZQ ? $ATIZQ->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $ATIZQ ? $ATIZQ->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $ATIZQ ? $ATIZQ->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $ATIZQ ? $ATIZQ->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $ATIZQ ? $ATIZQ->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $ATIZQ ? $ATIZQ->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} totalrow" num="7" type="number" value="{{ $ATIZQ ? $ATIZQ->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow7" class="form-control {{ $ATIZQ ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $ATIZQ ? $ATIZQ->total_money : '' }}" readonly="">
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

                    @php
                      $ADDER = $b_items->where('part', 'ADD')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $ADDER ? 'item-row-active' : 'no-to-send' }}" numrow="8">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Del. Der.</span>
                          <span class="subtitle-size minor-height">right front wing/aile AVD</span>
                          <input class="form-control" type="hidden" name="part[]" value="ADD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $ADDER ? $ADDER->material : '' }}">
                          <p class="text-center text-material8">{{ $ADDER ? ($ADDER->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $ADDER ? $ADDER->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $ADDER ? $ADDER->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $ADDER ? $ADDER->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $ADDER ? $ADDER->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $ADDER ? $ADDER->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $ADDER ? $ADDER->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $ADDER ? $ADDER->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $ADDER ? $ADDER->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ADDER ? '' : 'hidden-text' }} totalrow" num="8" type="number" value="{{ $ADDER ? $ADDER->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow8" class="form-control {{ $ADDER ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $ADDER ? $ADDER->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $PDDER = $b_items->where('part', 'PDD')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $PDDER ? 'item-row-active' : 'no-to-send' }}" numrow="9">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERETA Del. Der.</span>
                          <span class="subtitle-size minor-height">right front door/porte AVD</span>
                          <input class="form-control" type="hidden" name="part[]" value="PDD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $PDDER ? $PDDER->material : '' }}">
                          <p class="text-center text-material9">{{ $PDDER ? ($PDDER->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $PDDER ? $PDDER->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $PDDER ? $PDDER->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $PDDER ? $PDDER->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $PDDER ? $PDDER->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $PDDER ? $PDDER->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $PDDER ? $PDDER->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $PDDER ? $PDDER->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $PDDER ? $PDDER->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PDDER ? '' : 'hidden-text' }} totalrow" num="9" type="number" value="{{ $PDDER ? $PDDER->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow9" class="form-control {{ $PDDER ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $PDDER ? $PDDER->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $PTDER = $b_items->where('part', 'PTD')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $PTDER ? 'item-row-active' : 'no-to-send' }}" numrow="10">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">PUERTA Tras. Der.</span>
                          <span class="subtitle-size minor-height">right rear door/porte ARD</span>
                          <input class="form-control" type="hidden" name="part[]" value="PTD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $PTDER ? $PTDER->material : '' }}">
                          <p class="text-center text-material10">{{ $PTDER ? ($PTDER->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $PTDER ? $PTDER->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $PTDER ? $PTDER->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $PTDER ? $PTDER->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $PTDER ? $PTDER->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $PTDER ? $PTDER->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $PTDER ? $PTDER->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $PTDER ? $PTDER->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $PTDER ? $PTDER->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $PTDER ? '' : 'hidden-text' }} totalrow" num="10" type="number" value="{{ $PTDER ? $PTDER->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow10" class="form-control {{ $PTDER ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $PTDER ? $PTDER->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $MDER = $b_items->where('part', 'MD')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $MDER ? 'item-row-active' : 'no-to-send' }}" numrow="11">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">MONTANTE Der.</span>
                          <span class="subtitle-size minor-height">right rail/brancard D</span>
                          <input class="form-control" type="hidden" name="part[]" value="MD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $MDER ? $MDER->material : '' }}">
                        <p class="text-center text-material11">{{ $MDER ? ($MDER->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $MDER ? $MDER->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $MDER ? $MDER->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $MDER ? $MDER->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $MDER ? $MDER->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $MDER ? $MDER->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $MDER ? $MDER->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $MDER ? $MDER->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $MDER ? $MDER->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $MDER ? '' : 'hidden-text' }} totalrow" num="11" type="number" value="{{ $MDER ? $MDER->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow11" class="form-control {{ $MDER ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $MDER ? $MDER->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>

                    @php
                      $ATDER = $b_items->where('part', 'ATD')->first();
                    @endphp
                    <div class="form-row mt-1 hover-rows {{ $ATDER ? 'item-row-active' : 'no-to-send' }}" numrow="12">
                      <div style="width: 13.63%;">
                        <span class="bmd-form-group is-filled center-flex">
                          <span class="minor-height">ALETA Tras. Der.</span>
                          <span class="subtitle-size minor-height">right rear wing/aile ARD</span>
                          <input class="form-control" type="hidden" name="part[]" value="ATD">
                        </span>
                      </div>
                      <div style="width: 3%;">
                        <span class="bmd-form-group">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} text-center" type="hidden" autocomplete="off" name="material[]" value="{{ $ATDER ? $ATDER->material : '' }}">
                        <p class="text-center text-material12">{{ $ATDER ? ($ATDER->material == 'Aluminio' ? 'X' : '') : '' }}</p>
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumDS" type="number" value="{{ $ATDER ? $ATDER->small : '' }}" autocomplete="off" name="small_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumDM" type="number" value="{{ $ATDER ? $ATDER->medium : '' }}" autocomplete="off" name="medium_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumDB" type="number" value="{{ $ATDER ? $ATDER->big : '' }}" autocomplete="off" name="big_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumDP" type="number" value="{{ $ATDER ? $ATDER->paint : '' }}" autocomplete="off" name="topaint_damage[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumVDS" type="number" value="{{ $ATDER ? $ATDER->small_vds : '' }}" autocomplete="off" name="small_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumVDM" type="number" value="{{ $ATDER ? $ATDER->medium_vds : '' }}" autocomplete="off" name="medium_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumVDB" type="number" value="{{ $ATDER ? $ATDER->big_vds : '' }}" autocomplete="off" name="big_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} sumVDP" type="number" value="{{ $ATDER ? $ATDER->paint_vds : '' }}" autocomplete="off" name="topaint_vd[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input class="form-control {{ $ATDER ? '' : 'hidden-text' }} totalrow" num="12" type="number" value="{{ $ATDER ? $ATDER->total_vds : '' }}" autocomplete="off" name="totalrow[]" readonly="">
                        </span>
                      </div>
                      <div class="col-sm-1">
                        <span class="bmd-form-group is-filled">
                          <input id="totalMoneyRow12" class="form-control {{ $ATDER ? '' : 'hidden-text' }} totalMoneyRow" type="number" autocomplete="off" name="totalMoneyRow[]" value="{{ $ATDER ? $ATDER->total_money : '' }}" readonly="">
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-row text-center mt-3">
                      
                      <div class="col-sm-3"></div>

                      <div class="col-sm-2">Ajuste manual:</div>
                      <div class="col-sm-1">
                        <input id="manual-check" type="checkbox" name="manual_check" @if($budget->manual) checked @endif>
                      </div>
                      <div class="col-sm-2">
                        <input id="manual-total" type="number" min="0" @if($budget->manual) value="{{ $budget->grand_total - $budget->iva - $budget->desmontaje }}" @endif style="width: 100%;" @if(!$budget->manual) disabled="" @endif>
                      </div>

                      
                      <div class="col-sm-2">
                        Des/Montaje
                      </div>
                      <div class="col-sm-2">
                        <input id="desmontaje" name="desmontaje" type="number" min="0" value="{{ $budget->desmontaje }}" style="width: 100%;">
                      </div>

                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-row text-center mt-3">
                      <div class="col-sm-2">IVA:</div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1 btn-success total_iva">{{ $budget->iva }}</div>
                      <input id="iva_total" name="iva_total" type="hidden" value="{{ $budget->iva }}"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-row text-center">
                      <div class="col-sm-2">Totales:</div>
                      <div class="col-sm-1 btn-info totalDS">{{ $budget->items->sum('small') }}</div>
                      <div class="col-sm-1 btn-info totalDM">{{ $budget->items->sum('medium') }}</div>
                      <div class="col-sm-1 btn-info totalDB">{{ $budget->items->sum('big') }}</div>
                      <div class="col-sm-1 btn-info totalDP">{{ $budget->items->sum('paint') }}</div>
                      <div class="col-sm-1 btn-success totalVDS">{{ $budget->items->sum('small_vds') }}</div>
                      <div class="col-sm-1 btn-success totalVDM">{{ $budget->items->sum('medium_vds') }}</div>
                      <div class="col-sm-1 btn-success totalVDB">{{ $budget->items->sum('big_vds') }}</div>
                      <div class="col-sm-1 btn-success totalVDP">{{ $budget->items->sum('paint_vds') }}</div>
                      <div class="col-sm-1 btn-danger totalVD">{{ $budget->items->sum('total_vds') }}</div>
                      <div class="col-sm-1 btn-success totalEUR">{{ $budget->grand_total }}</div>
                      <input id="grand_total" name="grand_total" type="hidden" value="{{ $budget->grand_total }}">
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

  <input type="hidden" id="count-rows" value="{{ $budget->items->count() + 1 }}">
@endsection

@section('inlinejs')
  <script src="{{ asset('js/selectize.js') }}"></script>
  <script src="{{ asset('js/bootstrap-switch.js') }}"></script>
  <script>
    $(document).ready( function () {
      var rows = 0;

      // Funcion cuando cambia el toogle del material Aluminio/Hierro
      $('#materialcheck').change(function() {
        if ( this.checked ) {
          $(this).attr('material','Aluminio');
        }
        if ( !this.checked ) {
          $(this).attr('material','Hierro');
        }
      });

      // Funcion cuando cambia el toogle del material Aluminio/Hierro
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
        else if ( (s >= 251) && (s <= 280) )  { sVD = 100;}
        else if ( (s >= 281) && (s <= 340) )  { sVD = 105;}
        else if ( (s >= 341) && (s <= 390) )  { sVD = 110;}
        else if ( (s >= 391) && (s <= 460) )  { sVD = 120;}
        else if ( (s >= 461) && (s <= 520) )  { sVD = 130;}
        else if ( (s >= 521) && (s <= 600) )  { sVD = 145;}

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
        else if ( (m >= 81) && (m <= 100) ) { mVD = 84;}
        else if ( (m >= 101) && (m <= 120) ) { mVD = 100;}
        else if ( (m >= 121) && (m <= 140) ) { mVD = 122;}
        else if ( (m >= 141) && (m <= 160) ) { mVD = 135;}
        else if ( (m >= 161) && (m <= 200) ) { mVD = 148;}
        else if ( (m >= 201) && (m <= 230) ) { mVD = 164;}
        else if ( (m >= 231) && (m <= 250) ) { mVD = 182;}
        else if ( (m >= 251) && (m <= 280) ) { mVD = 191;}
        else if ( (m >= 281) && (m <= 340) ) { mVD = 202;}
        else if ( (m >= 341) && (m <= 390) ) { mVD = 216;}
        else if ( (m >= 391) && (m <= 460) ) { mVD = 230;}
        else if ( (m >= 461) && (m <= 520) ) { mVD = 248;}
        else if ( (m >= 521) && (m <= 600) ) { mVD = 270;}

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
        else if ( (b >= 101) && (b <= 120) ) { bVD = 150;}
        else if ( (b >= 121) && (b <= 140) ) { bVD = 183;}
        else if ( (b >= 141) && (b <= 160) ) { bVD = 202;}
        else if ( (b >= 161) && (b <= 200) ) { bVD = 221;}
        else if ( (b >= 201) && (b <= 230) ) { bVD = 245;}
        else if ( (b >= 231) && (b <= 250) ) { bVD = 272;}
        else if ( (b >= 251) && (b <= 280) ) { bVD = 285;}
        else if ( (b >= 281) && (b <= 340) ) { bVD = 301;}
        else if ( (b >= 341) && (b <= 390) ) { bVD = 321;}
        else if ( (b >= 391) && (b <= 460) ) { bVD = 342;}
        else if ( (b >= 461) && (b <= 520) ) { bVD = 368;}
        else if ( (b >= 521) && (b <= 600) ) { bVD = 400;}

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
        else if ( (p >= 101) && (p <= 120) ) { pVD = 105;}
        else if ( (p >= 121) && (p <= 140) ) { pVD = 128;}
        else if ( (p >= 141) && (p <= 160) ) { pVD = 141;}
        else if ( (p >= 161) && (p <= 200) ) { pVD = 155;}
        else if ( (p >= 201) && (p <= 230) ) { pVD = 172;}
        else if ( (p >= 231) && (p <= 250) ) { pVD = 190;}
        else if ( (p >= 251) && (p <= 280) ) { pVD = 200;}
        else if ( (p >= 281) && (p <= 340) ) { pVD = 211;}
        else if ( (p >= 341) && (p <= 390) ) { pVD = 225;}
        else if ( (p >= 391) && (p <= 460) ) { pVD = 329;}
        else if ( (p >= 461) && (p <= 520) ) { pVD = 258;}
        else if ( (p >= 521) && (p <= 600) ) { pVD = 280;}

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
        // let total = parseFloat(0);
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
      $('#select-boss').selectize({
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
      });
    });
  </script>
@endsection