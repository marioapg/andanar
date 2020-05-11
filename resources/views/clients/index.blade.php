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
            <div class="card-header card-header-warning">
              <h4 class="card-title ">{{ __('Clientes') }}</h4>
              <p class="card-category">{{ __('Listado clientes') }}</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('client.create') }}" class="btn btn-sm btn-warning">Nuevo cliente</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-warning">
                    <tr>
                      <th>
                        Nombre
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Fecha de creación
                      </th>
                      <th class="text-right">
                        Editar
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($clients as $client)
                      <tr>
                        <td>
                          {{ $client->name }}
                        </td>
                        <td>
                          {{ $client->email }}
                        </td>
                        <td>
                          {{ $client->created_at->format('d-m-Y') }}
                        </td>
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