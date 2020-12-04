@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Factura')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-info">
              <h4 class="card-title ">{{ __('Factura') }}</h4>
              <p class="card-category">{{ $budget->id }}</p>
            </div>
            <div class="card-body">
                <div id="invoice">
                  <div class="toolbar hidden-print">
                    <div class="col-md-8">
                        <a href="#" class="btn btn-success btn-link">
                          <i class="material-icons" style="color: orange;">edit</i>Editar
                        </a>
                    </div>

                    <div class="col-md-4">
                        <div class="text-right">
                            <form action="#" id="invoice-status" method="post">
                                @csrf
                                @method('put')
                                <select class="form-control mdb-select @if ($budget->status == 'payed') payed-invoice @elseif($budget->status == 'pending') pending-invoice @endif change-invoice-select" name="status" id="status" required>
                                    <option value="pending" {{ ($budget->status == 'pending') ? ' selected' : '' }}>Pendiente</option>
                                    <option value="payed" {{ ($budget->status == 'payed') ? ' selected' : '' }}>Pagada</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <hr>
                  </div>
    
                    <div class="invoice overflow-auto">
                      <div style="min-width: 600px">
                        
                            <main>
                                <div class="row contacts">
                                    <div class="col invoice-to">
                                        <div class="text-gray-light">Facturado a:</div>
                                        <h2 class="to">{{ $budget->client->name }}</h2>
                                        <div class="address">{{ $budget->client->address }}</div>
                                        <div class="email"><a href="mailto:{{ $budget->client->email }}">{{ $budget->client->email }}</a></div>
                                    </div>
                                    <div class="col invoice-details">
                                        <h1 class="invoice-id">N° {{ $budget->id }}</h1>
                                        <div class="date">Fecha: {{ $budget->date }}</div>
                                        <div class="date">Fecha de vencimiento: {{ $budget->due_date }}</div>
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
                                        @foreach( $budget->items as $key => $item)
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
                                            <td>{{ $budget->total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2">IVA {{ $budget->iva_rate }}%</td>
                                            <td>{{ $budget->iva }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2">TOTAL</td>
                                            <td>{{ $budget->grand_total }}</td>
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
                    </div>
                </div>   
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection