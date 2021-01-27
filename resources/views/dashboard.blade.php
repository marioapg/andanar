@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_copy</i>
              </div>
              <p class="card-category">Presupuestos</p>
              <h3 class="card-title">{{ \App\Budget::all()->count() }}
                {{--<small>GB</small>--}}
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                {{--<i class="material-icons">assignment</i> <a href="#">Ventas</a>/<a href="#">Gastos</a>--}}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
          <a href="{{ route('clients.index') }}">
            <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">face</i>
                </div>
                <p class="card-category">Clientes</p>
                @if(auth()->user()->hasRole('admin'))
                  <h3 class="card-title">{{ \App\Client::all()->count() }}</h3>
                @else
                  <h3 class="card-title">{{ \App\Client::where('created_by', auth()->user()->id)->count() }}</h3>
                @endif
              </div>
              <div class="card-footer">
                <div class="stats">
                  {{--<i class="material-icons">date_range</i> Registrados--}}
                </div>
              </div>
            </div>
          </a>
        </div>
        
        @if(auth()->user()->hasRole('admin'))
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="#">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">payment</i>
                  </div>
                  <p class="card-category">Varilleros</p>
                  <h3 class="card-title">{{ \App\User::where('type','technical')->count() }}
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    {{--<i class="material-icons">assignment</i> Facturas recibidas--}}
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush