@extends('layouts.app', ['activePage' => 'cars', 'titlePage' => __('Listado autos')])

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
              <h4 class="card-title ">Coches</h4>
              <p class="card-category">Coches registrados</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <a href="{{ route('car.create') }}" class="btn btn-sm btn-info">Nuevo auto</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table" id="cars-table">
                  <thead class=" text-info">
                    <tr>
                      <th>
                        Marca
                      </th>
                      <th>
                        Modelo
                      </th>
                      <th class="text-right">
                        Editar
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($cars as $car)
                      <tr>
                        <td>
                          {{ $car->brand }}
                        </td>
                        <td>
                          {{ $car->model }}
                        </td>
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('car.show', ['id' => $car->id]) }}" data-original-title="" title="">
                            <i class="material-icons">edit</i>
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

@section('inlinejs')
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('#cars-table').DataTable({
        // dom:"Blfrtip",
        dom:"lfrtip",
        scrollX: false,
        paging: true,
        pageLength: 20,
        lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "Todas"]],
        aaSorting: [],
        // order: [[0, 'desc']],
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