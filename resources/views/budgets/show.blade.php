@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Factura')])

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
                     <h4 class="card-title ">{{ __('Presupuesto') }}</h4>
                     <p class="card-category">{{ $budget->id }}</p>
                  </div>

                  <div class="card-body">
                     <div id="invoice">
                        <div class="toolbar hidden-print row">
                           <div class="col">
                              <a href="#">
                                 <button class="btn btn-primay">
                                    <i class="material-icons">edit</i>
                                    Editar
                                 </button>
                              </a>
                           </div>

                           <div class="col">
                              <button class="btn btn-success send-mail-popup">
                                 <i class="material-icons">email</i>
                                 Enviar email
                              </button>
                           </div>

                           <div class="col">
                              <form action="{{ route('budget.status', $budget->id) }}" id="invoice-status" method="post" style="padding: 8px;">
                                 @csrf
                                 @method('put')
                                 <select class="form-control mdb-select change-invoice-select {{$budget->status}}-class" name="status" id="status" required style="border-radius: 3px; color: white;">
                                    <option value="presupuestado" {{ ($budget->status == 'presupuestado') ? ' selected' : '' }}>Presupuestado</option>
                                    <option value="rechazado" {{ ($budget->status == 'rechazado') ? ' selected' : '' }}>Rechazado</option>
                                    <option value="aceptado" {{ ($budget->status == 'aceptado') ? ' selected' : '' }}>Aceptado</option>
                                    <option value="proceso" {{ ($budget->status == 'proceso') ? ' selected' : '' }}>Proceso</option>
                                    <option value="terminado" {{ ($budget->status == 'terminado') ? ' selected' : '' }}>Terminado</option>
                                    <option value="facturado" {{ ($budget->status == 'facturado') ? ' selected' : '' }}>Facturado</option>
                                    <option value="cobrado" {{ ($budget->status == 'cobrado') ? ' selected' : '' }}>Cobrado</option>
                                 </select>
                              </form>
                           </div>
                        </div>

                        <!-- <div class="invoice overflow-auto"> -->
                        <div class="overflow-auto mt-3">
                           <div style="min-width: 600px">
                              <table class="head-budget" style="width:100%;">
                                 <tr>
                                    <td>Coche Nro</td>
                                    <td>{{ $budget->car->id ?? '' }}</td>
                                    <td>Fecha</td>
                                    <td>{{ $budget->date ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Matrícula</td>
                                    <td>{{ $budget->car->plate ?? '' }}</td>
                                    <td>Cliente</td>
                                    <td>{{ $budget->client->name ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Marca</td>
                                    <td>{{ $budget->car->brand ?? '' }}</td>
                                    <td>Dirección</td>
                                    <td>{{ $budget->client->address ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Modelo</td>
                                    <td>{{ $budget->car->model ?? '' }}</td>
                                    <td>Ciudad</td>
                                    <td>{{ $budget->client->city ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Color</td>
                                    <td>{{ $budget->car->color ?? '' }}</td>
                                    <td>CP</td>
                                    <td>{{ $budget->client->postal_code ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Cia. Seguro</td>
                                    <td>{{ $budget->cia_sure ?? '' }}</td>
                                    <td>País</td>
                                    <td>{{ $budget->client->country ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Perito</td>
                                    <td>{{ $budget->perito->name ?? '' }}</td>
                                    <td>Teléfono</td>
                                    <td>{{ $budget->client->phone ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Tlf Perito</td>
                                    <td>{{ $budget->perito->phone ?? '' }}</td>
                                    <td>CIF/NIF/DNI</td>
                                    <td>{{ $budget->client->document ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Mail Perito</td>
                                    <td>{{ $budget->perito->mail ?? '' }}</td>
                                    <td>Responsable</td>
                                    <td>{{ $budget->responsable->name ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Técnico</td>
                                    <td>{{ $budget->technical->name ?? '' }}</td>
                                    <td>Mail Responsable</td>
                                    <td>{{ $budget->responsable->mail ?? '' }}</td>
                                 </tr>
                                 <tr>
                                    <td>Mail Técnico</td>
                                    <td>{{ $budget->technical->mail ?? '' }}</td>
                                    <td></td>
                                    <td></td>
                                 </tr>
                              </table>

                              <table class="body-budget mt-3" style="width: 100%; text-align: center;">
                                 <tr style="background-color: #C5C5C5; font-weight: bold;">
                                    <td style="width: 20%;">DETALLE COMPONENTE</td>
                                    <td style="width: 7%;">MATERIAL</td>
                                    <td colspan="4">DIMENSION ABOLLADURAS</td>
                                    <td colspan="3">Nro VD's</td>
                                    <td colspan="2" rowspan="2">P/P</td>
                                    <td rowspan="2">Total VD's Fila</td>
                                 </tr>
                                 <tr style="background-color: #C5C5C5;font-weight: bold;">
                                    <td colspan="2">Plano</td>
                                    <td>2 cm</td>
                                    <td>3 cm</td>
                                    <td>5 cm</td>
                                    <td>P/P</td>
                                    <td>2 cm</td>
                                    <td>3 cm</td>
                                    <td>5 cm</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $b_items = $budget->items;
                                       $capot = $b_items->where('part', 'CAPOT')->first();
                                    @endphp
                                    <td style="width: 20%;">CAPÓ</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->material : '' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $capot ? $capot->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $capot ? $capot->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $capot ? $capot->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $techo = $b_items->where('part', 'TECHO')->first();
                                    @endphp
                                    <td style="width: 20%;">TECHO</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->material : '' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $techo ? $techo->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $techo ? $techo->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $techo ? $techo->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $maletero = $b_items->where('part', 'MALETERO')->first();
                                    @endphp
                                    <td style="width: 20%;">MALETERO</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->material : '' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $maletero ? $maletero->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $maletero ? $maletero->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $maletero ? $maletero->total_vds : '0' }}</td>
                                 </tr>
                                 <tr style="background-color: #C5C5C5;font-weight: bold;">
                                    <td colspan="12">Lateral Izquierdo</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $ADIZQ = $b_items->where('part', 'ADI')->first();
                                    @endphp
                                    <td style="width: 20%;">Aleta Delantera</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->material : '' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $ADIZQ ? $ADIZQ->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $ADIZQ ? $ADIZQ->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $PDIZQ = $b_items->where('part', 'PDI')->first();
                                    @endphp
                                    <td style="width: 20%;">Puerta Delantera</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->material : '' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $PDIZQ ? $PDIZQ->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $PDIZQ ? $PDIZQ->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $PTIZQ = $b_items->where('part', 'PTI')->first();
                                    @endphp
                                    <td style="width: 20%;">Puerta Trasera</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->material : '' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $PTIZQ ? $PTIZQ->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $PTIZQ ? $PTIZQ->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $MIZQ = $b_items->where('part', 'MI')->first();
                                    @endphp
                                    <td style="width: 20%;">Montante</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->material : '' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $MIZQ ? $MIZQ->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $MIZQ ? $MIZQ->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $MIZQ ? $MIZQ->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $ATIZQ = $b_items->where('part', 'ATI')->first();
                                    @endphp
                                    <td style="width: 20%;">Aleta trasera</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->material : '' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $ATIZQ ? $ATIZQ->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $ATIZQ ? $ATIZQ->total_vds : '0' }}</td>
                                 </tr>
                                 <tr style="background-color: #C5C5C5;font-weight: bold;">
                                    <td colspan="12">Lateral Derecho</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $ADDER = $b_items->where('part', 'ADD')->first();
                                    @endphp
                                    <td style="width: 20%;">Aleta Delantera</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->material : '' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ADDER ? $ADDER->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $ADDER ? $ADDER->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $ADDER ? $ADDER->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $PDDER = $b_items->where('part', 'PDD')->first();
                                    @endphp
                                    <td style="width: 20%;">Puerta Delantera</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->material : '' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PDDER ? $PDDER->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $PDDER ? $PDDER->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $PDDER ? $PDDER->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $PTDER = $b_items->where('part', 'PTD')->first();
                                    @endphp
                                    <td style="width: 20%;">Puerta Trasera</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->material : '' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $PTDER ? $PTDER->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $PTDER ? $PTDER->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $PTDER ? $PTDER->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $MDER = $b_items->where('part', 'MD')->first();
                                    @endphp
                                    <td style="width: 20%;">Montante</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->material : '' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $MDER ? $MDER->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $MDER ? $MDER->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $MDER ? $MDER->total_vds : '0' }}</td>
                                 </tr>
                                 <tr>
                                    @php
                                       $ATDER = $b_items->where('part', 'ATD')->first();
                                    @endphp
                                    <td style="width: 20%;">Aleta trasera</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->material : '' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->small : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->medium : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->big : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->paint : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->small_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->medium_vds : '0' }}</td>
                                    <td style="width: 7%;">{{ $ATDER ? $ATDER->big_vds : '0' }}</td>
                                    <td colspan="2">{{ $ATDER ? $ATDER->paint_vds : '0' }}</td>
                                    <td style="width: 10%;">{{ $ATDER ? $ATDER->total_vds : '0' }}</td>
                                 </tr>
                                 <tr style="background-color: #C5C5C5;font-weight: bold;">
                                    <td colspan="12">Otros</td>
                                 </tr>
                                    <!-- <tr>
                                       <td style="width: 20%;">Frente/Cola/Varios</td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 7%;"></td>
                                       <td style="width: 10%;"></td>
                                    </tr> -->
                                 <tr>
                                    @php
                                       $total_vds = 0;
                                       $total_s = 0;
                                       $total_m = 0;
                                       $total_b = 0;
                                       $total_p = 0;
                                       foreach($b_items as $item) {
                                          $total_vds += $item->total_vds;
                                          $total_s += $item->small;
                                          $total_m += $item->medium;
                                          $total_b += $item->big;
                                          $total_p += $item->paint;
                                       }
                                    @endphp
                                    <td rowspan="3">Tarifa PDR</td>
                                    <td rowspan="3">{{ $budget->tarifa_pdr }}</td>
                                    <td colspan="4" rowspan="3"></td>
                                    <td colspan="5">Total VD's</td>
                                    <td style="width: 10%;">{{ $total_vds }}</td>
                                 </tr>
                                 <tr>
                                    <td colspan="5">Reperación Varillas</td>
                                    <td style="width: 10%;">{{ $budget->total }}</td>
                                 </tr>
                                 <tr>
                                    <td colspan="5">_</td>
                                    <td style="width: 10%;"></td>
                                 </tr>
                                 <tr>
                                    <td style="width: 20%;">Total Abolladuras</td>
                                    <td style="width: 7%;"></td>
                                    <td style="width: 7%;">{{ $total_s }}</td>
                                    <td style="width: 7%;">{{ $total_m }}</td>
                                    <td style="width: 7%;">{{ $total_b }}</td>
                                    <td style="width: 7%;">{{ $total_p }}</td>
                                    <td colspan="5">TOTAL PRESUPUESTO</td>
                                    <td style="width: 10%;">{{ $budget->grand_total }}</td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">Comentarios para cliente</td>
                                    <td colspan="10">{{ $budget->public_comment }}</td>
                                 </tr>
                                 <tr>
                                    <td colspan="2">Comentarios para Andanar</td>
                                    <td colspan="10">{{ $budget->private_comment }}</td>
                                 </tr>
                              </table>
                           </div>
                        </div>
                     </div>   
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="myModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <form action="{{ route('budget.send.mail', $budget->id) }}" method="POST">
               @csrf
               <div class="modal-header">
                  <h5 class="modal-title">
                     Enviar emails
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Perito</span>
                     </div>
                     <div class="col text-left">
                        <input name="peritomail" type="text" value="{{ $budget->perito ? $budget->perito->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="peritocheck" type="checkbox" {{ $budget->perito ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Técnico</span>
                     </div>
                     <div class="col text-left">
                        <input name="tecnicomail" type="text" value="{{ $budget->technical ? $budget->technical->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="tecnicocheck" type="checkbox" {{ $budget->technical ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Cliente</span>
                     </div>
                     <div class="col text-left">
                        <input name="clientemail" type="text" value="{{ $budget->client ? $budget->client->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="clientecheck" type="checkbox" {{ $budget->client ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Otros</span>
                     </div>
                     <div class="col text-left">
                        <input name="otrosmails" type="text" value="" placeholder="separe los emails con ,">
                     </div>
                     <div class="col text-left">
                        <input name="otroscheck" type="checkbox">
                     </div>
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection

@section('inlinejs')
   <script>
      $(document).ready(function(){
         $('.send-mail-popup').on('click', function(e){
            $('#myModal').modal('show');
         });
      });
   </script>
@endsection