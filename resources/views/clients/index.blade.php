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
                <div class="col-12 text-right">
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
                      <th>
                        Email
                      </th>
                      <th>
                        Teléfono
                      </th>
                      <th>
                        Fecha de creación
                      </th>
                      @if(auth()->user()->hasRole('admin'))
                        <th class="text-right">
                          Eliminar
                        </th>
                      @endif
                      <th class="text-right">
                        Editar
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($clients as $client)
                      <tr>
                        <td>
                          {{ $client->id }}
                        </td>
                        <td>
                          {{ $client->name }}
                        </td>
                        <td>
                          {{ $client->email }}
                        </td>
                        <td>
                          {{ $client->phone }}
                        </td>
                        <td>
                          {{ $client->created_at->format('d-m-Y') }}
                        </td>
                        @if(auth()->user()->hasRole('admin'))
                          <td class="td-actions text-right">
                            <form action="{{ route('client.delete', ['id' => $client->id]) }}" method="POST">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="btn btn-success btn-link">
                                <i class="material-icons" style="color: red;">delete_forever</i>
                              </button>
                            </form>
                          </td>
                        @endif
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('client.show', ['id' => $client->id]) }}" data-original-title="" title="">
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