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
              <h4 class="card-title ">Autos</h4>
              <p class="card-category">Listado de autos registrados</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                  <!-- <a href="{{ route('car.create') }}" class="btn btn-sm btn-info">Nuevo auto</a> -->
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-info">
                    <tr>
                      <th>
                        Marca
                      </th>
                      <th>
                        Modelo
                      </th>
                      <th>
                        Color
                      </th>
                      <th>
                        Placa
                      </th>
                      <th>
                        Fecha
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
                        <td>
                          {{ $car->color }}
                        </td>
                        <td>
                          {{ $car->plate }}
                        </td>
                        <td>
                          {{ $car->created_at->format('d-m-Y') }}
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