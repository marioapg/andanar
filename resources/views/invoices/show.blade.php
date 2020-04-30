@extends('layouts.app', ['activePage' => 'invoice-list', 'titlePage' => __('Factura')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{ __('Factura') }}</h4>
              <p class="card-category">{{ $invoice->id }}</p>
            </div>
            <div class="card-body">
              <!--Author      : @arboshiki-->
<div id="invoice">

    {{--
      <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    --}}
    <div class="invoice overflow-auto">
      <div style="min-width: 600px">
        <header>
          <div class="row">
            <div class="col">
              <img src="http://lobianijs.com/lobiadmin/version/1.0/ajax/img/logo/lobiadmin-logo-text-64.png" data-holder-rendered="true" />
            </div>
            <div class="col company-details">
              <h2 class="name">
                TelcoGes
              </h2>
              <div>455 Av, Ciudad 85004, US</div>
              <div>(123) 456-789</div>
              <div>telcoges@example.com</div>
          </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">Facturado a:</div>
                        <h2 class="to">{{ $invoice->client->name }}</h2>
                        <div class="address">{{ $invoice->client->address }}</div>
                        <div class="email"><a href="mailto:{{ $invoice->client->email }}">{{ $invoice->client->email }}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">N° {{ $invoice->id }}</h1>
                        <div class="date">Fecha: {{ $invoice->date }}</div>
                        <div class="date">Fecha de vencimiento: {{ $invoice->due_date }}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">Descripción</th>
                            <th class="text-right">Cantidad</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Monto</th>
                            <th class="text-right">Iva</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $invoice->items as $key => $item)
                        <tr>
                          <td class="no">{{ $key }}</td>
                            <td class="text-left"><h3>{{ $item->name }}</h3>{{ $item->description }}</td>
                            <td class="qty">{{ $item->quantity }}</td>
                            <td class="unit">{{ $item->price }}</td>
                            <td class="unit">{{ $item->total }}</td>
                            <td class="unit">{{ $item->tax }}</td>
                            <td class="total">{{ $item->grand_total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>{{ $invoice->total }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">IVA {{ $invoice->iva_rate }}%</td>
                            <td>{{ $invoice->iva }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="2">TOTAL</td>
                            <td>{{ $invoice->grand_total }}</td>
                        </tr>
                    </tfoot>
                </table>
                {{--
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>
                --}}
            </main>
            <footer>
              {{--
                Invoice was created on a computer and is valid without the signature and seal.
              --}}
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection