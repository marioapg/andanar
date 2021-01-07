@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuesto')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="POST" action="{{ route('budget.update', $budget->id) }}" enctype="multipart/form-data">
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
                    <label for="boss_id">Encargado taller</label>
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
                      <option value="USD" nombre="Dolar" @if($budget->currency == 'USD') selected="" @endif>
                        Dolar
                      </option>
                      <option value="EUR" nombre="Euros" @if($budget->currency == 'EUR') selected="" @endif>
                        Euros
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
                    <label for="private_comment">Comentario para Andanar</label>
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

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 15%">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Aleta del der" abpart="ADD" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/top 1.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Puerta del der" abpart="PDD" style="float: left;width: 17%">
                      <img src="{{ asset('images/car_graph/top 2.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Puerta tra der" abpart="PTD" style="float: left;width: 14%">
                      <img src="{{ asset('images/car_graph/top 3.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Aleta tra der" abpart="ATD" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/top 4.png') }}" alt="">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 21%">
                    </div>
                    <!-- <div class="col hover-custom" style="float: left;width: 8%">
                      <img src="{{ asset('images/car_graph/adelante.png') }}" alt="">
                    </div> -->
                    <div class="col hover-custom add-item-budget" part="Capot" abpart="CAPOT" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/mid 1.png') }}" alt="">
                    </div>
                    <div class="col" style="float: left;width: 20%">
                      <img class="hover-custom add-item-budget" part="Montante derecho" abpart="MD" src="{{ asset('images/car_graph/mid 4.png') }}" alt="">
                      <img class="hover-custom add-item-budget" part="Techo" abpart="TECHO" src="{{ asset('images/car_graph/mid 2.png') }}" alt="">
                      <img class="hover-custom add-item-budget" part="Montante izquierdo" abpart="MI" src="{{ asset('images/car_graph/mid 5.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Maletero" abpart="MALETERO" style="float: left;width: 16%">
                      <img src="{{ asset('images/car_graph/mid 3.png') }}" alt="">
                    </div>
                    <!-- <div class="col hover-custom" style="float: left;width: 9%">
                      <img src="{{ asset('images/car_graph/atras.png') }}" alt="">
                    </div> -->
                  </div>

                  <div class="col-md-12">
                    <div class="col" style="float: left;width: 15%">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Aleta del izq" abpart="ADI" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/bot 1.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Puerta del izq" abpart="PDI" style="float: left;width: 17%">
                      <img src="{{ asset('images/car_graph/bot 2.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Puerta tra izq" abpart="PTI" style="float: left;width: 14%">
                      <img src="{{ asset('images/car_graph/bot 3.png') }}" alt="">
                    </div>
                    <div class="col hover-custom add-item-budget" part="Aleta del izq" abpart="ATI" style="float: left;width: 19%">
                      <img src="{{ asset('images/car_graph/bot 4.png') }}" alt="">
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                  <div class="col-md-12" id="items-budget">
                    <div class="form-row mt-3">
                      <div class="col-md-1 text-center btn-primary">
                        <strong>
                          Parte
                        </strong>
                      </div>
                      <div class="col-md-1 text-center btn-warning">
                        <strong>
                          Material
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
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12" id="items-budget">
                    @foreach($budget->items as $key => $item)
                      <div class="form-row mt-1 hover-rows" numrow="{{ $key }}">
                        <div class="col-md-1">
                          <input class="form-control" type="text" name="part[]" value="{{ $item->part }}" readonly></input>
                        </div>
                        <div class="col-md-1">
                          <input class="form-control" type="text" name="material[]" value="{{ $item->material }}" readonly>
                        </div>
                        <div class="col-md-1">
                          <input class="form-control sumDS" type="text" name="small_damage[]" value="{{ $item->small }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumDM" type="text" name="medium_damage[]" value="{{ $item->medium }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumDB" type="text" name="big_damage[]" value="{{ $item->big }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumDP" type="text" name="topaint_damage[]" value="{{ $item->paint }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumVDS" type="text" name="small_vd[]" value="{{ $item->small_vds }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumVDM" type="text" name="medium_vd[]" value="{{ $item->medium_vds }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumVDB" type="text" name="big_vd[]" value="{{ $item->big_vds }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control sumVDP" type="text" name="topaint_vd[]" value="{{ $item->paint_vds }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control totalrow" type="text" name="totalrow[]" value="{{ $item->total_vds }}" readonly>
                        </div>

                        <div class="col-md-1">
                          <input class="form-control totalMoneyRow" type="text" name="totalMoneyRow[]" value="{{ $item->total_money }}" readonly>
                        </div>
                      </div>
                    @endforeach
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
                      <div class="col-md-1 btn-success total_iva">
                        {{ $budget->iva }}
                      </div>
                      <input id="iva_total" name="iva_total" type="hidden" value="{{ $budget->iva }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" id="items-budget">
                    <div class="form-row text-center">
                      <div class="col-md-2">Totales:</div>
                      <div class="col-md-1 btn-info totalDS">{{ $budget->items->sum('small') }}</div>
                      <div class="col-md-1 btn-info totalDM">{{ $budget->items->sum('medium') }}</div>
                      <div class="col-md-1 btn-info totalDB">{{ $budget->items->sum('big') }}</div>
                      <div class="col-md-1 btn-info totalDP">{{ $budget->items->sum('paint') }}</div>
                      <div class="col-md-1 btn-success totalVDS">{{ $budget->items->sum('small_vds') }}</div>
                      <div class="col-md-1 btn-success totalVDM">{{ $budget->items->sum('medium_vds') }}</div>
                      <div class="col-md-1 btn-success totalVDB">{{ $budget->items->sum('big_vds') }}</div>
                      <div class="col-md-1 btn-success totalVDP">{{ $budget->items->sum('paint_vds') }}</div>
                      <div class="col-md-1 btn-danger totalVD">{{ $budget->items->sum('total_vds') }}</div>
                      <div class="col-md-1 btn-success totalEUR">
                        {{ $budget->grand_total }}
                      </div>
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
              <input type="checkbox" name="material" id="materialcheck" material='Hierro' autocomplete="off">
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

      $('#select-client').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        }
      });
      $('#select-perito').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        }
      });
      $('#select-technical').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        }
      });
      $('#select-boss').selectize({
        create: false,
        sortField: {
          field: 'text',
          direction: 'asc'
        }
      });

      var rows = parseInt($('#count-rows').val());

      // Funcion cuando cambia el toogle del material Aluminio/Hierro
      $('#materialcheck').change(function() {
        if ( this.checked ) {
          $(this).attr('material','Aluminio');
        }
        if ( !this.checked ) {
          $(this).attr('material','Hierro');
        }
      });

      // Boton para agregar ya la fila
      $('.add-row').on('click', function(e){
        var qtySmall = 0;
        var s = parseInt( $('#small_size').val() );
        var m = parseInt( $('#medium_size').val() );
        var b = parseInt( $('#big_size').val() );
        var p = parseInt( $('#to_paint').val() );

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

        if ( $('#materialcheck').attr('material') == 'Aluminio') {
          sVD = parseInt(sVD + (sVD * 0.2));
          mVD = parseInt(mVD + (mVD * 0.2));
          bVD = parseInt(bVD + (bVD * 0.2));
          pVD = parseInt(pVD + (pVD * 0.2));
        }

        let totalVDs = sVD+mVD+bVD+pVD;
        let totalEur = totalVDs * parseInt($('#tarifa_pdr').val());

        var row;
        row = `
              <div class="form-row mt-1 hover-rows" numrow="`+rows+`">
                <div class="col-md-1">
                  <input class="form-control" type="text" name="part[]" value="`+$('#add-part').val()+`" readonly></input>
                </div>
                <div class="col-md-1">
                  <input class="form-control" type="text" name="material[]" value="`+$('#materialcheck').attr('material')+`" readonly>
                </div>
                <div class="col-md-1">
                  <input class="form-control sumDS" type="text" name="small_damage[]" value="`+$('#small_size').val()+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumDM" type="text" name="medium_damage[]" value="`+$('#medium_size').val()+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumDB" type="text" name="big_damage[]" value="`+$('#big_size').val()+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumDP" type="text" name="topaint_damage[]" value="`+$('#to_paint').val()+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumVDS" type="text" name="small_vd[]" value="`+sVD+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumVDM" type="text" name="medium_vd[]" value="`+mVD+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumVDB" type="text" name="big_vd[]" value="`+bVD+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control sumVDP" type="text" name="topaint_vd[]" value="`+pVD+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control totalrow" type="text" name="totalrow[]" value="`+totalVDs+`" readonly>
                </div>

                <div class="col-md-1">
                  <input class="form-control totalMoneyRow" type="text" name="totalMoneyRow[]" value="`+totalEur+`" readonly>
                </div>
              </div>`;

        rows++;
        $('#items-budget').append(row);

        $('#small_size').val(0);
        $('#medium_size').val(0);
        $('#big_size').val(0);
        $('#to_paint').val(0);
        calculateTotals();
        $('#myModal').modal('hide');
      });
      
      $(document).on('click', '.hover-rows', function(e){
        $(this).remove();
        calculateTotals();
      });

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

        X = 0;
        $('.totalMoneyRow').each(function(){
          X += parseInt($(this).val());
        });
        $('.totalEUR').html('');
        var iva = parseFloat($('#iva_rate').val()) / 100;

        var iva_total = X * iva;
        var total_con_iva = X + iva_total;

        var result_iva = parseFloat(iva_total).toFixed(2);
        var result_total = parseFloat(total_con_iva).toFixed(2);
        $('#iva_total').val( result_iva );
        $('.total_iva').html( result_iva );
        $('#grand_total').val( result_total );
        $('.totalEUR').html( result_total );
      }

      // Iniciacion del toogle de los mataeriales
      $('#materialcheck').bootstrapSwitch({
          on: 'Aluminio', // default 'On'
          off: 'Hierro', // default 'Off'
          onLabel: 'Aluminio', //default ''
          offLabel: 'Hierro', //default ''
          same: false, // default false. same text for on/off and onLabel/offLabel
          size: 'md', // xs/sm/md/lg, default 'md'
          onClass: 'success', //success/primary/danger/warning/default, default 'primary'
          offClass: 'success', //success/primary/danger/warning/default default 'default'
      });

      // Cuando se selecciona una parte del carro
      $('.add-item-budget').on('click', function(e) {
        $('.modal-title').html( $(this).attr('part') );
        $('#add-part').val( $(this).attr('abpart') );
        $('#myModal').modal('show');
      });

      // $('#select-brand').on('change', function(e){
      //   if ( $(this).val() ) {
      //     const models_url = '/cars/' + $(this).val() + '/models';
      //     $.ajax({
      //       url: models_url,
      //       success: function(response) {
      //        $('#select-model').selectize()[0].selectize.destroy();
      //         $('#select-model').empty();
      //         $('#select-model').append(response);
      //         $('#select-model').selectize({
      //           create: false,
      //           sortField: {
      //             field: 'text',
      //             direction: 'asc'
      //           },
      //           dropdownParent: 'body'
      //         });
      //       }
      //     });
      //   } else {
      //     $('#select-model').selectize()[0].selectize.destroy();
      //     $('#select-model').empty();
      //     $('#select-model').append('<option value=""></option>');
      //     $('#select-model').selectize({
      //       create: false,
      //       sortField: {
      //         field: 'text',
      //         direction: 'asc'
      //       },
      //       dropdownParent: 'body'
      //     });
      //   }
      // });

      $('#select-currency').on('change', function(e){
        var obj = $("#select-currency option:selected");
        $('#total-currency').html( 'Total ' + obj.text() );
      });
    });
  </script>
@endsection