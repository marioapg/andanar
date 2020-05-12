@extends('layouts.app', ['activePage' => 'invoice-list', 'titlePage' => __('Nueva factura')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="POST" action="{{ route('invoice.store') }}">
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
                  <h4 class="card-title ">{{ __('Facturas') }}</h4>
                  <p class="card-category">{{ __('Nueva factura') }}</p>
                </div>
                <div class="card-body">

                  <div class="form-row invoice-row-input">
                    <div class="col input-box">
                      <label for="client">Cliente</label>
                      <input type="text" class="form-control typeahead" placeholder="@" id="client" name="client" value="{{ old('client') }}" required autocomplete="off">
                      <div id="clientList">
                        
                      </div>
                      <input type="hidden" id="clientid" name="clientid" value="1">
                      @if ($errors->has('clientid'))
                        <div id="clientid-error" class="error text-danger pl-3" for="clientid" style="display: block;">
                          <strong>{{ $errors->first('clientid') }}</strong>
                        </div>
                      @endif
                      @if ($errors->has('client'))
                        <div id="client-error" class="error text-danger pl-3" for="client" style="display: block;">
                          <strong>{{ $errors->first('client') }}</strong>
                        </div>
                      @endif
                    </div>
                    <div class="col input-box">
                      <label for="doc_number">Número documentos</label>
                      <input type="text" class="form-control" id="doc_number" name="doc_number" value="{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ $newNumDoc }}" required>
                    </div>
                    <div class="col input-box">
                      <label for="date">Fecha</label>
                      <input type="date" id="date" name="date" class="form-control" placeholder="Fecha" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col input-box">
                      <label for="due_date">Vencimiento</label>
                      <input type="date" id="due_date" name="due_date" class="form-control" placeholder="Vencimiento" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    
                  </div>

                  <div class="form-row invoice-row-input">
                    <div class="col input-box">
                      <label for="comment">Mensaje visible en factura</label>
                      <textarea class="form-control" name="comment" id="comment" value="{{ old('comment') }}" rows="2"></textarea>
                    </div>
                    <div class="col input-box">
                      <label for="status">Estatus</label>
                      <select class="form-control mdb-select" name="status" id="status" required>
                        <option value="pending" selected="">Pendiente</option>
                        <option value="payed">Pagada</option>
                      </select>
                    </div>
                    <div class="col input-box">
                      <label for="type">Tipo</label>
                      <select class="form-control mdb-select" name="type" id="type" required>
                        <option value="sell" {{ $type == 'sell' ? ' selected' : ' disabled' }}>Venta</option>
                        <option value="buy" {{ $type == 'buy' ? ' selected' : ' disabled ' }}>Gasto</option>
                      </select>
                    </div>
                    <div class="col input-box">
                      <label for="pay_way">Forma de pago</label>
                      <select class="form-control mdb-select" name="pay_way" id="pay_way" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="tdcredito">Tarjeta de Credito</option>
                        <option value="tddebito">Tarjeta de debido</option>
                      </select>
                    </div>
                  </div>

                  <div class="card form-row" style="display: flex;flex-direction: column;align-items: center;">
                    <div class="card-body">
                      <h3 class="card-title">Nueva linea</h3>
                    </div>
                  </div>

                  @if ($errors->has('itemname'))
                    <div id="itemname-error" class="error text-danger pl-3" for="itemname" style="display: block;">
                      <strong>{{ $errors->first('itemname') }}</strong>
                    </div>
                  @endif
                  @if ($errors->has('itemname.*'))
                    <div id="itemname.*-error" class="error text-danger pl-3" for="itemname.*" style="display: block;">
                      <strong>{{ $errors->first('itemname.*') }}</strong>
                    </div>
                  @endif

                  <div class="form-row add-item-to-invoice">
                    <div class="col" style="display: flex;flex-direction: column;align-items: center;">
                      <i class="material-icons">add_circle</i>
                    </div>
                  </div>

                  <div class="container add-items">
                    
                  </div>

                  <div class="form-row">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                      <label for="grandSubTotal">Subtotal</label>
                      <input id="grandSubTotal" class="form-control" type="text" disabled="" value="0">
                    </div>
                    <div class="col">
                      <label for="grandIva">Iva</label>
                      <input id="grandIva" class="form-control" type="text" disabled="" value="0">
                    </div>
                    <div class="col">
                      <label for="grandTotal">Total</label>
                      <input id="grandTotal" class="form-control" type="text" disabled="" value="0">
                    </div>
                  </div>

                  <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-info">{{ __('Crear') }}</button>
                  </div>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
@endsection