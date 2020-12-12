@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuesto')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="POST" action="{{ route('budget.create.step.three') }}">
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
                <h4 class="card-title ">{{ __('Matricula: ') }} {{ session()->get('car')->plate ?? '' }}</h4>
                <p class="card-category">{{ __('Presupuesto/vehículo: ') }} </p>
              </div>
              <div class="card-body">
                <div class="row">
                  
                <div class="col">
                  <div class="form-group">
                    <label for="title">Cliente:</label>
                    <select name="client_id" id="select-client" required="">
                      <option value=""></option>
                      @foreach( \App\Client::all() as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                    <label for="description">Perito:</label>
                    <select name="proficient_id" id="select-perito">
                      <option value=""></option>
                      @foreach( \App\User::where('type','proficient')->where('status',1)->get() as $proficient)
                        <option value="{{ $proficient->id }}">{{ $proficient->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                      <label for="description">Técnico:</label>
                      <select name="technical_id" id="select-technical">
                        <option value=""></option>
                        @foreach( \App\User::where('type','technical')->where('status',1)->get() as $technical)
                          <option value="{{ $technical->id }}">{{ $technical->name }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-info">{{ __('Siguiente') }}</button>
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
    $('#select-client').selectize({
      create: false,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });
    $('#select-perito').selectize({
      create: false,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });
    $('#select-technical').selectize({
      create: false,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });

    $('#select-brand').on('change', function(e){
      if ( $(this).val() ) {
        const models_url = '/cars/' + $(this).val() + '/models';
        $.ajax({
          url: models_url,
          success: function(response) {
           $('#select-model').selectize()[0].selectize.destroy();
            $('#select-model').empty();
            $('#select-model').append(response);
            $('#select-model').selectize({
              create: false,
              sortField: {
                field: 'text',
                direction: 'asc'
              },
              dropdownParent: 'body'
            });
          }
        });
      } else {
        $('#select-model').selectize()[0].selectize.destroy();
        $('#select-model').empty();
        $('#select-model').append('<option value=""></option>');
        $('#select-model').selectize({
          create: false,
          sortField: {
            field: 'text',
            direction: 'asc'
          },
          dropdownParent: 'body'
        });
      }
    });
  </script>
@endsection