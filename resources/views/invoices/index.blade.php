@extends('layouts.app', ['activePage' => 'invoice-list', 'titlePage' => __('Listado facturas')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Facturas') }}</h4>
              <p class="card-category">{{ __('Listado facturas') }}</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-primary">Nueva factura</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                      <th>Número</th>
                      <th>Documento</th>
                      <th>Fecha</th>
                      <th>IVA</th>
                      <th>Total</th>
                      <th>Tipo</th>
                      <th class="text-right">Ver</th>
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
                            <i class="material-icons" style="color: green;">call_made</i>
                          @elseif($invoice->type == 'buy')
                            <i class="material-icons" style="color: red;">call_received</i>
                          @endif
                        </td>
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('invoice.show', ['id' => $invoice->id]) }}" data-original-title="" title="">
                            <i class="material-icons">remove_red_eye</i>
                            <div class="ripple-container"></div>
                          </a>
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