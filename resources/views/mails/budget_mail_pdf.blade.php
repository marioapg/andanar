<head>
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        p {
            margin:0px;
        }
    </style>
</head>

<div id="invoice" style="font-size: 12px;">
   <div style="min-width: 600px">
        <table class="head-budget" style="width:100%;border-collapse: collapse;">
            <tr>
                <td colspan="2" style="text-align: center;">
                    <img src="{{ asset('/images/logo.jpg') }}" width="200">
                </td>
                <td colspan="2">
                    <p style="text-align: center;">
                        c/ Nil Fabra, 34 Entlo. 2° B (08012) BCN España <br>
                        Tel. +34 93 237 42 41 - <strong>Móv. +34 645 500 227</strong> <br>
                        info@andanar.com - www.andanar.com
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width:50%;">
                    <p style="text-align: center;">
                        <strong>
                            PRESUPUESTO /Budget/Devis <br>
                            Valoración de daños /Damage/Dommage
                        </strong>
                    </p>
                </td>
                <td>
                    <p style="text-align: center;">
                        <strong>N°</strong><br>
                        {{ $budget->id }}
                    </p>
                </td>
                <td>
                    <p style="text-align: center;">
                        <strong>Fecha</strong><br>
                        {{ \Carbon\Carbon::create($budget->date)->format('d/m/Y') ?? '' }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CLIENTE:</strong> {{ $budget->client->name ?? '' }} <br>
                        <small>customer/client</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MATRÍCULA:</strong> {{ $budget->car->plate ?? '' }} <br>
                        <small>license/immatric</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>DIRECCIÓN:</strong> {{ $budget->client->address ?? '' }} <br>
                        <small>address/adresse</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MARCA:</strong> {{ $budget->car->brand ?? '' }}<br>
                        <small>brand card/marque</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CIUDAD:</strong> {{ $budget->client->city ?? '' }}<br>
                        <small>city/ville</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MODELO:</strong> {{ $budget->car->model ?? '' }}<br>
                        <small>model/modele</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CP:</strong> {{ $budget->client->postal_code ?? '' }}<br>
                        <small>PC/CP</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>COLOR:</strong> {{ $budget->car->color ?? '' }}<br>
                        <small>color/couleur</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>PAÍS:</strong> {{ $budget->client->country ?? '' }}<br>
                        <small>country/pays</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>Cia SEGUROS:</strong> {{ $budget->cia_sure ?? '' }}<br>
                        <small>insurance/assurance</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>TEL:</strong> {{ $budget->client->phone ?? '' }}<br>
                        <small>phone/teléphone</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>PERITO:</strong> {{ $budget->perito->name ?? '' }}<br>
                        <small>expert/évaluateur</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CIF:</strong> {{ $budget->client->document ?? '' }}<br>
                        <small>tax ID/ident. Fiscale</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>Tel. PERITO:</strong> {{ $budget->perito->phone ?? '' }}<br>
                        <small>ph. expert/tél expert</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>RESPONSABLE:</strong> {{ $budget->responsable->name ?? '' }}<br>
                        <small>responsible/responsable</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MAIL PERITO:</strong> {{ $budget->perito->mail ?? '' }}<br>
                        <small>expert email</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>MAIL RESP.</strong> {{ $budget->responsable->mail ?? '' }}<br>
                        <small>res. email/email res.</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong></strong><br>
                        <small></small>
                    </p>
                </td>
            </tr>
        </table>

        <table class="body-budget mt-3" style="margin-top: 5px; width: 100%; border-collapse: collapse;text-align: center;">
         <tr style="background-color: #C5C5C5; font-weight: bold;">
            <td style="width: 20%;">{{ $budget->tarifa_pdr }}</td>
            <td style="width: 7%;">AL</td>
            <td colspan="4">Abolladuras por tamaño <br> Dents/Dommages</td>
            <td colspan="5">Parciales VDs <br> Partial/Partiel VDs </td>
            <td colspan="2">Total VD's Fila</td>
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
            <td colspan="2">P/P</td>
            <td colspan="2"></td>
         </tr>
         @foreach($budget->items as $item)
             <tr>
                <td style="width: 20%;">
                    {{ $item->pieceName($item->part) }} <br>
                    <small>{{ $item->pieceTranslation($item->part) }}</small>
                </td>
                <td style="width: 7%;">{{ $item->material == 'Aluminio' ? 'X' : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->small : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->medium : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->big : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->paint : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->small_vds : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->medium_vds : '' }}</td>
                <td style="width: 7%;">{{ $item ? $item->big_vds : '' }}</td>
                <td colspan="2">{{ $item ? $item->paint_vds : '' }}</td>
                <td colspan="2" style="width: 10%;">{{ $item ? $item->total_vds : '' }}</td>
             </tr>
         @endforeach

            @php
                $b_items = $budget->items;
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
             <tr>
                <td style="width: 27%;" colspan="2">
                    <strong>Total Bollos</strong>
                    <small>dents/bosses</small>
                </td>
                <td style="width: 7%;">{{ $total_s }}</td>
                <td style="width: 7%;">{{ $total_m }}</td>
                <td style="width: 7%;">{{ $total_b }}</td>
                <td style="width: 7%;">{{ $total_p }}</td>
                <td colspan="5">
                    <strong>
                        TOTAL VDs / {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                    </strong>
                </td>
                <td style="width: 10%;" colspan="2">{{ $total_vds }} VDs</td>
            </tr>
            <tr>
                <td colspan="4" rowspan="3">
                    <strong>
                        Observaciones.        
                    </strong>
                    <br>
                    <small>
                        remarks/observations
                    </small>
                    <br>
                    {{ $budget->public_comment }}
                </td>
                <td colspan="3" style="border-right: none;">
                    <small>dentwork/debosselage</small> <br>
                    <strong>Reparación Varillas</strong>
                </td>
                <td colspan="2" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;">
                    {{ $budget->total }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-right: none;">
                    <small>dis-assembly/dé-remontage</small> <br>
                    <strong>Des/Montaje</strong>
                </td>
                <td colspan="2" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;">
                    {{ $budget->desmontaje }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-right: none;">
                    <strong>TOTAL</strong>
                </td>
                <td colspan="2" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;">
                    <p>
                        {{ $budget->grand_total }} + IVA
                    </p>
                </td>
            </tr>
                <tr>
                <td colspan="4">
                    <strong>TÉCNICO</strong> <small>Technical/Technicien</small>
                </td>
                <td colspan="9">
                    <strong>CONFORME CLIENTE</strong> Firma y Sello -- <small>customer ok/conformité</small>
                </td>
            </tr>
            <tr style="height: 100px;max-height: 100px;">
                <td colspan="4" style="height: 100px;max-height: 100px;">
                </td>
                <td colspan="9" style="height: 100px;max-height: 100px;">
                </td>
            </tr>
        </table>
   </div>
    <p style="text-align: center;">Andanar Europe S.L. Reg. Merc. N° 38617 F° 69 Hoja 328878 -- NIF: B-64216047</p>
</div>

<div style="margin-top: 100px;">
    @if( !is_null($budget->attached) )
       @foreach( $budget->attached as $key => $value )
            <img src="{{ asset('/images/budgets/') }}/{{ $value }}" width="500">
       @endforeach
    @endif
</div>