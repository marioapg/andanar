@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuestos')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/zebra_datepicker.min.css') }}"> 
@endsection

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
              <h4 class="card-title ">{{ __('Presupuestos') }}</h4>
              <p class="card-category">{{ __('Listado presupuestos') }}</p>
            </div>
            <div class="card-body">
              @if ( auth()->user()->type != 'proficient' ) 
              <div class="row">
                <div class="col-sm-6 text-left">
                  <form action="{{ route('export.budgets') }}" method="POST" class="center-responsive-one">
                    @method('POST')
                    @csrf

                    Desde
                    <input id="from" type="text" class="datepicker-from" name="from" autocomplete="off">
                    <br>
                    Hasta
                    <input id="to" type="text" class="datepicker-to" name="to" autocomplete="off">
                    <button class="btn btn-sm btn-warning">Exportar</button>

                  </form>
                </div>
                <div class="col-sm-3 text-right">
                </div>
                <div class="col-sm-3 text-right" style="display: flex;flex-direction: column;align-items: center;">
                  <a href="{{ route('budget.create.step.one') }}" class="btn btn-sm btn-info">Nuevo presupuesto</a>
                </div>
              </div>
              @endif
              <div class="table-responsive">
                <table class="table text-center" id="budget-table">
                  <thead class="text-info">
                    <tr>
                      <th>Número</th>
                      <th>Placa</th>
                      <th>Cliente</th>
                      <th>Fecha</th>
                      <th>IVA</th>
                      <th>Total</th>
                      <th>Estatus</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($budgets as $budget)
                      <tr>
                        <td>
                            {{ $budget->id }}
                        </td>
                        <td>
                          <a href="{{ route('budget.show',$budget->id) }}">
                            {{ $budget->car->plate ?? '' }}
                          </a>
                        </td>
                        <td>
                          {{ $budget->client->name }}
                        </td>
                        <td>
                          {{ \Carbon\Carbon::create($budget->date)->format('d-m-Y') }}
                        </td>
                        <td>
                          {{ $budget->iva }}
                        </td>
                        <td>
                          {{ $budget->grand_total }}
                        </td>
                        <td>
                          <div class="text-center border-{{$budget->status}}" style="width: 100%;">
                          {{ ucwords($budget->status) }}
                          </div>
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

@section('inlinejs')
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/zebra_datepicker.min.js') }}"></script>

  <script>
    $(document).ready(function() {

      $('.datepicker-from').Zebra_DatePicker({
        format: 'd-m-Y',
        show_select_today: false,
        show_clear_date: false,
        show_other_months: true,
        select_other_months: true,
        days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
      });

      $('.datepicker-to').Zebra_DatePicker({
        format: 'd-m-Y',
        show_select_today: false,
        show_clear_date: false,
        show_other_months: true,
        select_other_months: true,
        days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
      });

      $('#budget-table').DataTable({
        // dom:"Blfrtip",
        dom:"lfrtip",
        scrollX: false,
        paging: true,
        pageLength: 20,
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "Todas"]],
        aaSorting: [],
        order: [[0, 'desc']],
        language: {
                processing:     "Procesando...",
                search:         "",
                searchPlaceholder: "Buscar",
                info:           "",
                lengthMenu:     "Mostrar _MENU_",
                infoEmpty:      "Vacío",
                infoFiltered:   "Información refinada",
                infoPostFix:    "",
                loadingRecords: "Procesando...",
                zeroRecords:    "Vacio",
                emptyTable:     "Vacio",
                paginate: {
                    first:      "Primero",
                    previous:   "<",
                    next:       ">",
                    last:       "Último"
                },
                aria: {
                    sortAscending:  ": Ordenar ascendente",
                    sortDescending: ": Ordenar descendente"
                }
            }
      });
    })
  </script>
@endsection