<head>
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<div id="invoice">
    <!-- <div class="invoice overflow-auto"> -->
    <div class="overflow-auto mt-3">
       <div style="min-width: 600px">
          <table class="head-budget" style="width:100%;border-collapse: collapse;">
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

          <table class="body-budget mt-3" style="margin-top: 5px; width: 100%; border-collapse: collapse;text-align: center;">
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
             @foreach($budget->items as $item)
                 <tr>
                    <td style="width: 20%;font-size: 12px;">{{ $item->pieceName($item->part) }}</td>
                    <td style="width: 7%;">{{ $item->material == 'Aluminio' ? 'X' : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->material : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->small : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->medium : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->big : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->paint : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->small_vds : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->medium_vds : '' }}</td>
                    <td style="width: 7%;">{{ $item ? $item->big_vds : '' }}</td>
                    <td colspan="2">{{ $item ? $item->paint_vds : '' }}</td>
                    <td style="width: 10%;">{{ $item ? $item->total_vds : '' }}</td>
                 </tr>
             @endforeach
             <!--<tr>
                @php
                   $b_items = $budget->items;
                   $capot = $b_items->where('part', 'CAPOT')->first();
                @endphp
                <td style="width: 20%;">CAPÓ</td>
                <td style="width: 7%;">{{ $capot ? $capot->material : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->small : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->medium : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->big : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->paint : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $capot ? $capot->big_vds : '' }}</td>
                <td colspan="2">{{ $capot ? $capot->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $capot ? $capot->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $techo = $b_items->where('part', 'TECHO')->first();
                @endphp
                <td style="width: 20%;">TECHO</td>
                <td style="width: 7%;">{{ $techo ? $techo->material : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->small : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->medium : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->big : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->paint : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $techo ? $techo->big_vds : '' }}</td>
                <td colspan="2">{{ $techo ? $techo->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $techo ? $techo->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $maletero = $b_items->where('part', 'MALETERO')->first();
                @endphp
                <td style="width: 20%;">MALETERO</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->material : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->small : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->medium : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->big : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->paint : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $maletero ? $maletero->big_vds : '' }}</td>
                <td colspan="2">{{ $maletero ? $maletero->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $maletero ? $maletero->total_vds : '' }}</td>
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
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->small : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->medium : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->big : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->paint : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $ADIZQ ? $ADIZQ->big_vds : '' }}</td>
                <td colspan="2">{{ $ADIZQ ? $ADIZQ->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $ADIZQ ? $ADIZQ->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $PDIZQ = $b_items->where('part', 'PDI')->first();
                @endphp
                <td style="width: 20%;">Puerta Delantera</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->material : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->small : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->medium : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->big : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->paint : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $PDIZQ ? $PDIZQ->big_vds : '' }}</td>
                <td colspan="2">{{ $PDIZQ ? $PDIZQ->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $PDIZQ ? $PDIZQ->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $PTIZQ = $b_items->where('part', 'PTI')->first();
                @endphp
                <td style="width: 20%;">Puerta Trasera</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->material : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->small : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->medium : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->big : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->paint : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $PTIZQ ? $PTIZQ->big_vds : '' }}</td>
                <td colspan="2">{{ $PTIZQ ? $PTIZQ->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $PTIZQ ? $PTIZQ->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $MIZQ = $b_items->where('part', 'MI')->first();
                @endphp
                <td style="width: 20%;">Montante</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->material : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->small : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->medium : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->big : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->paint : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $MIZQ ? $MIZQ->big_vds : '' }}</td>
                <td colspan="2">{{ $MIZQ ? $MIZQ->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $MIZQ ? $MIZQ->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $ATIZQ = $b_items->where('part', 'ATI')->first();
                @endphp
                <td style="width: 20%;">Aleta trasera</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->material : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->small : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->medium : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->big : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->paint : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $ATIZQ ? $ATIZQ->big_vds : '' }}</td>
                <td colspan="2">{{ $ATIZQ ? $ATIZQ->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $ATIZQ ? $ATIZQ->total_vds : '' }}</td>
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
                <td style="width: 7%;">{{ $ADDER ? $ADDER->small : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->medium : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->big : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->paint : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $ADDER ? $ADDER->big_vds : '' }}</td>
                <td colspan="2">{{ $ADDER ? $ADDER->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $ADDER ? $ADDER->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $PDDER = $b_items->where('part', 'PDD')->first();
                @endphp
                <td style="width: 20%;">Puerta Delantera</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->material : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->small : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->medium : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->big : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->paint : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $PDDER ? $PDDER->big_vds : '' }}</td>
                <td colspan="2">{{ $PDDER ? $PDDER->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $PDDER ? $PDDER->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $PTDER = $b_items->where('part', 'PTD')->first();
                @endphp
                <td style="width: 20%;">Puerta Trasera</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->material : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->small : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->medium : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->big : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->paint : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $PTDER ? $PTDER->big_vds : '' }}</td>
                <td colspan="2">{{ $PTDER ? $PTDER->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $PTDER ? $PTDER->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $MDER = $b_items->where('part', 'MD')->first();
                @endphp
                <td style="width: 20%;">Montante</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->material : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->small : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->medium : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->big : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->paint : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $MDER ? $MDER->big_vds : '' }}</td>
                <td colspan="2">{{ $MDER ? $MDER->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $MDER ? $MDER->total_vds : '' }}</td>
             </tr>
             <tr>
                @php
                   $ATDER = $b_items->where('part', 'ATD')->first();
                @endphp
                <td style="width: 20%;">Aleta trasera</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->material : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->small : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->medium : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->big : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->paint : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $ATDER ? $ATDER->big_vds : '' }}</td>
                <td colspan="2">{{ $ATDER ? $ATDER->paint_vds : '' }}</td>
                <td style="width: 10%;">{{ $ATDER ? $ATDER->total_vds : '' }}</td>
             </tr>-->
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
                <td rowspan="3"></td>
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
                <td colspan="2">Comentarios</td>
                <td colspan="10">{{ $budget->public_comment }}</td>
             </tr>
          </table>
       </div>
    </div>
</div>