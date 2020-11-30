@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuestos')])

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
              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('budget.create.step.one') }}" class="btn btn-sm btn-info">Nuevo presupuesto</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-info">
                    <tr>
                      <th>Número</th>
                      <th>Fecha</th>
                      <th>Total</th>
                      <th class="text-right">Ver</th>
                      <th class="text-right">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($budgets as $budget)
                      <tr>
                        <td>
                          {{ $budget->id }}
                        </td>
                        <td>
                          {{ $budget->doc_number }}
                        </td>
                        <td>
                          {{ \Carbon\Carbon::create($budget->date)->format('d-m-Y') }}
                        </td>
                        <td>
                          {{ $budget->total }}
                        </td>
                        <td class="td-actions text-right">
                          <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('budget.show') }}" data-original-title="" title="">
                            <i class="material-icons @if($budget->status == 'pending') pending-budget-eye-icon @endif">remove_red_eye</i>
                            <div class="ripple-container"></div>
                          </a>
                        </td>
                        <td class="td-actions text-right">
                          <form action="{{ route('budget.delete', ['id' => $budget->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-success btn-link">
                              <i class="material-icons" style="color: red;">delete_forever</i>
                            </button>
                          </form>
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