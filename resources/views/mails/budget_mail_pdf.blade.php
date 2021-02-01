<head>
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        @page {
          margin-top: 0px;
        }
        #invoice {
            font-family: calibri, sans-serif;
            font-size: 11px;
        }
        p {
            margin:0px;
        }
        small {
            font-style: italic;
        }
        .cursiva-azul {
            font-style: italic;
            color: blue;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>

<div id="invoice">
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
                            PRESUPUESTO / Budget / Devis <br>
                            Valoración de Daños / Damage / Dommage
                        </strong>
                    </p>
                </td>
                <td>
                    <p style="text-align: center;">
                        <strong>N°</strong><br>
                        <strong class="cursiva-azul">
                            {{ $budget->id }}
                        </strong>
                    </p>
                </td>
                <td>
                    <p style="text-align: center;">
                        <strong>Fecha / Date</strong><br>
                        <strong class="cursiva-azul">
                            {{ \Carbon\Carbon::create($budget->date)->format('d/m/Y') ?? '' }}
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CLIENTE:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->name ?? '' }}
                        </strong>
                        <br>
                        <small>customer / client</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MATRÍCULA:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->car->plate ?? '' }}
                        </strong>
                        <br>
                        <small>license / immatric</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>DIRECCIÓN:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->address ?? '' }}
                        </strong>
                        <br>
                        <small>address / adresse</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MARCA:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->car->brand ?? '' }}
                        </strong>
                        <br>
                        <small>brand card / marque</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CIUDAD:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->city ?? '' }}
                        </strong>
                        <br>
                        <small>city / ville</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MODELO:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->car->model ?? '' }}
                        </strong>
                        <br>
                        <small>model / modele</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CP:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->postal_code ?? '' }}
                        </strong>
                        <br>
                        <small>PC / CP</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>COLOR:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->car->color ?? '' }}
                        </strong>
                        <br>
                        <small>color / couleur</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>PAÍS:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->country ?? '' }}
                        </strong>
                        <br>
                        <small>country / pays</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>Cia SEGUROS:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->cia_sure ?? '' }}
                        </strong>
                        <br>
                        <small>insurance / assurance</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>TEL:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->phone ?? '' }}
                        </strong>
                        <br>
                        <small>phone / teléphone</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>PERITO:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->perito->name ?? '' }}
                        </strong>
                        <br>
                        <small>expert / évaluateur</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>CIF:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->client->document ?? '' }}
                        </strong>
                        <br>
                        <small>tax ID / ident. Fiscale</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>Tel. PERITO:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->perito->phone ?? '' }}
                        </strong>
                        <br>
                        <small>ph. expert / tél expert</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>RESPONSABLE:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->responsable->name ?? '' }}
                        </strong>
                        <br>
                        <small>responsible / responsable</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>MAIL PERITO:</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->perito->email ?? '' }}
                        </strong>
                        <br>
                        <small>expert email</small>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>
                        <strong>MAIL RESP.</strong>
                        <strong class="cursiva-azul"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ $budget->responsable->email ?? '' }}
                        </strong>
                        <br>
                        <small>res. email / email res.</small>
                    </p>
                </td>
                <td colspan="2">
                    <p>
                        <strong>REALIZÓ</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong class="cursiva-azul">
                            {{ $budget->technical->name ?? '' }}
                        </strong>
                        <br>
                        <small>made / fait</small>
                    </p>
                </td>
            </tr>
        </table>

        <table class="body-budget mt-3" style="margin-top: 5px; width: 100%; border-collapse: collapse;text-align: center;">
         <tr style="background-color: #C5C5C5; font-weight: bold;">
            @if($budget->manual)
                <td style="width: 30%;text-align: left;font-weight: normal;font-size: 8px;">
            @else
                <td style="width: 30%;text-align: left;font-weight: normal;">
            @endif
                {{ $budget->tarifa_pdr }}
            </td>
            <td style="width: 2%">AL</td>
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
                <td style="text-align: left;">
                    <strong>
                        {{ $item->pieceName($item->part) }}
                    </strong>
                    <br>
                    <small>{{ $item->pieceTranslation($item->part) }}</small>
                </td>
                <td>{{ $item->material == 'Aluminio' ? 'X' : '' }}</td>
                <td>{{ $item ? ($item->small ? $item->small : '') : '' }}</td>
                <td>{{ $item ? ($item->medium ? $item->medium : '') : '' }}</td>
                <td>{{ $item ? ($item->big ? $item->big : '') : '' }}</td>
                <td>{{ $item ? ($item->paint ? $item->paint : '') : '' }}</td>
                <td>{{ $item ? ($item->small_vds ? $item->small_vds : '') : '' }}</td>
                <td>{{ $item ? ($item->medium_vds ? $item->medium_vds : '') : '' }}</td>
                <td>{{ $item ? ($item->big_vds ? $item->big_vds : '') : '' }}</td>
                <td colspan="2">{{ $item ? ($item->paint_vds ? $item->paint_vds : '') : '' }}</td>
                <td colspan="2">{{ $item ? $item->total_vds : '' }}</td>
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
                <td colspan="2" style="text-align: left;line-height: 25px;">
                    <strong style="font-size: 13px;">Total Bollos.</strong>
                    <small>dents / bosses</small>
                </td>
                <td style="width: 7%;">{{ ($total_s ? $total_s : '') }}</td>
                <td style="width: 7%;">{{ ($total_m ? $total_m : '') }}</td>
                <td style="width: 7%;">{{ ($total_b ? $total_b : '') }}</td>
                <td style="width: 7%;">{{ ($total_p ? $total_p : '') }}</td>
                <td colspan="5">
                    <strong>
                        TOTAL VDs
                    </strong>
                </td>
                <td style="width: 10%;" colspan="2">{{ $total_vds }} VDs</td>
            </tr>
            <tr>
                <td colspan="4" rowspan="3" style="text-align: left;" padding>
                    <p @if (is_null($budget->public_comment)) style="margin-top: -20px;" @endif>
                        <strong>
                            Observaciones.        
                        </strong>
                        <small>
                            remarks / observations
                        </small>
                    </p>
                    <p class="cursiva-azul">
                    {{ $budget->public_comment }}
                    </p>
                </td>
                <td colspan="4" style="border-right: none;text-align: left;">
                    <strong>Reparación Varillas</strong> <br>
                    <small>dentwork / debosselage</small>
                </td>
                <td colspan="1" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;text-align: left;">
                    {{ $budget->total - $budget->desmontaje }}
                </td>
            </tr>
            <tr style="height: 40px;">
                <td colspan="4" style="border-right: none; text-align: left;">
                    <strong>Des / Montaje</strong> <br>
                    <small>dis-assembly / dé-remontage</small>
                </td>
                <td colspan="1" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;text-align: left;">
                    {{ $budget->desmontaje }}
                </td>
            </tr>
            <tr style="height: 40px;">
                <td colspan="4" style="border-right: none;text-align: left;">
                    <strong>TOTAL</strong><br>
                </td>
                <td colspan="1" style="border-right: none;border-left: none;">
                    {{ \App\Utils\Currencies::getSymbol($budget->currency) }}
                </td>
                <td colspan="4" style="border-left: none;text-align: left;">
                    <p>
                        <strong>{{ $budget->total }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+ IVA</strong>
                    </p>
                </td>
            </tr>
                <tr>
                <td colspan="4">
                    <strong>TÉCNICO</strong> <small>Technic / Technicien</small>
                </td>
                <td colspan="9">
                    <strong>CONFORME CLIENTE</strong> Firma y Sello -- <small>customer ok / conformité</small>
                </td>
            </tr>
            <tr style="height: 70px;max-height: 70px;">
                <td colspan="4" style="height: 70px;max-height: 70px;">
                </td>
                <td colspan="9" style="height: 70px;max-height: 70px;">
                </td>
            </tr>
        </table>
   </div>
    <p style="text-align: center;">Andanar Europe S.L. Reg. Merc. N° 38617 F° 69 Hoja 328878 -- NIF: B-64216047</p>
</div>

@if( !is_null($budget->attached) )
    <div style="margin-top: 100px;">
        @foreach( $budget->attached as $key => $value )
            <img src="{{ asset('/images/budgets/') }}/{{ $value }}" width="500">
        @endforeach
    </div>
@endif