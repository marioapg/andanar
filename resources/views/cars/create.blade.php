@extends('layouts.app', ['activePage' => 'cars-management', 'titlePage' => __('Coche')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('car.store') }}" autocomplete="off" class="form-horizontal">
            @csrf

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
                <h4 class="card-title ">{{ __('Coche: ') }}</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <div class="row">
                  
                <div class="col">
                  <div class="form-group">
                    <label for="title">Marca:</label>
                    <select name="brand" id="select-brand" required="">
                      <option value=""></option>
                      @foreach( \App\DBCar::select('brand')->get() as $brand)
                        <option value="{{ $brand->brand }}" modelsurl="{{ route('car.models.by.brand', [$brand->brand]) }}">{{ $brand->brand }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col">
                  <div class="">
                    <label for="description">Modelo:</label>
                    <input class="form-control" name="model" value="" id="model" required="">
                  </div>
                </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-info">{{ __('Guardar') }}</button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('inlinejs')
  <script src="{{ asset('js/selectize.js') }}"></script>
  <script>
    $('#select-brand').selectize({
      create: true,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });

  </script>
@endsection