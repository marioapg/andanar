@extends('layouts.app', ['activePage' => 'invoice-list-'.$type, 'titlePage' => __('Listado facturas')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
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
              <p class="card-category">{{ __('Listado facturas') }}</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('invoice.create', ['type' => $type]) }}" class="btn btn-sm btn-info">Nueva factura</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-info">
                    <tr>
                      <th>Número</th>
                      <th>Documento</th>
                      <th>Fecha</th>
                      <th>IVA</th>
                      <th>Total</th>
                      <th>Tipo</th>
                      <th class="text-right">Ver</th>
                      <th class="text-right">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($invoices as $invoice)
                      <tr>
                        <td>
                          {{ $invoice->id }}
                        </td>
                        <td>
                          {{ $invoice->doc_number }}
                        </td>
                        <td>
                          {{ \Carbon\Carbon::create($invoice->date)->format('d-m-Y') }}
                        </td>
                        <td>
                          {{ $invoice->iva }}
                        </td>
                        <td>
                          {{ $invoice->total }}
                        </td>
                        <td>
                          @if($invoice->type == 'sell')
                            <i class="material-icons sell-invoice-color">call_made</i>
                          @elseif($invoice->type == 'buy')
                            <i class="material-icons buy-invoice-color">call_received</i>
                          @endif
                        </td>
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('invoice.show', ['id' => $invoice->id]) }}" data-original-title="" title="">
                            <i class="material-icons @if($invoice->status == 'pending') pending-invoice-eye-icon @endif">remove_red_eye</i>
                            <div class="ripple-container"></div>
                          </a>
                        </td>
                        <td class="td-actions text-right">
                          <form action="{{ route('invoice.delete', ['id' => $invoice->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-success btn-link">
                              <i class="material-icons" style="color: red;">delete_forever</i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection