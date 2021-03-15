@extends('layouts.app', ['activePage' => 'clients', 'titlePage' => __('Listado clientes')])

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
              <h4 class="card-title ">{{ __('Clientes') }}</h4>
              <p class="card-category">{{ __('Listado clientes') }}</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <a href="{{ route('client.create') }}" class="btn btn-sm btn-info">Nuevo cliente</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table" id="clients-table">
                  <thead class=" text-info">
                    <tr>
                      <th>
                        N°
                      </th>
                      <th>
                        Nombre
                      </th>
                      @if(auth()->user()->hasRole('admin'))
                        <th>
                          Email
                        </th>
                        <th>
                          Teléfono
                        </th>
                        <th>
                          Fecha de creación
                        </th>
                      @else
                        <th>
                          Dirección
                        </th>
                        <th>
                          País
                        </th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($clients as $client)
                      <tr>
                        <td>
                          {{ $client->id }}
                        </td>
                        <td>
                          <a href="{{ route('client.show', ['id' => $client->id]) }}">
                            {{ $client->name }}
                          </a>
                        </td>
                        @if(auth()->user()->hasRole('admin'))
                          <td>
                            {{ $client->email }}
                          </td>
                          <td>
                            {{ $client->phone }}
                          </td>
                          <td>
                            {{ $client->created_at->format('d-m-Y') }}
                          </td>
                        @else
                          <td>
                            {{ $client->address }}
                          </td>
                          <td>
                            {{ $client->country }}
                          </td>
                        @endif
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
      $('#clients-table').DataTable({
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