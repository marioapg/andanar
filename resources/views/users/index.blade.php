@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Listado usuarios')])

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
              <h4 class="card-title ">Usuarios</h4>
              <p class="card-category">Listado de usuarios</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('user/create') }}" class="btn btn-sm btn-info">Crear usuario</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-info">
                    <tr>
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
                      <th>
                        Tipo
                      </th>
                      <th>
                        Estatus
                      </th>
                      <th class="text-right">
                        Editar
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td>
                          {{ $user->name }}
                        </td>
                        <td>
                          {{ $user->email }}
                        </td>
                        <td>
                          {{ $user->phone }}
                        </td>
                        <td>
                          {{ $user->created_at->format('d-m-Y') }}
                        </td>
                        <td>
                          @if($user->type == 'technical') Tecnico
                          @elseif($user->type == 'proficient') Perito
                          @endif
                        </td>
                        <td>
                          @if($user->status == 1) Activo <i class="material-icons" style="color: green;">assignment_turned_in</i>
                          @elseif($user->status == 0) Inactivo <i class="material-icons" style="color: red;">assignment_late</i>
                          @endif
                        </td>
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('user.show', ['id' => $user->id]) }}" data-original-title="" title="">
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