@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Presupuesto')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="POST" action="{{ route('budget.create.step.two') }}">
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
                  <div class="form-group">
                    <label for="description">Modelo:</label>
                    <select name="model" id="select-model" required="">
                      
                    </select>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                      <label for="description">Color:</label>
                      <select name="color" id="select-color" required="">
                        <option value=""></option>
                        <option value="amarillo">amarillo</option>
                        <option value="ámbar">ámbar</option>
                        <option value="añil">añil</option>
                        <option value="azul">azul</option>
                        <option value="azul claro">azul claro</option>
                        <option value="azul eléctrico">azul eléctrico</option>
                        <option value="azul marino">azul marino</option>
                        <option value="beis">beis</option>
                        <option value="bermellón">bermellón</option>
                        <option value="blanco ">blanco </option>
                        <option value="blanco marfil">blanco marfil</option>
                        <option value="burdeos">burdeos</option>
                        <option value="café">café</option>
                        <option value="caoba o">caoba o</option>
                        <option value="caqui  ">caqui  </option>
                        <option value="carmesí ">carmesí </option>
                        <option value="castaño">castaño</option>
                        <option value="celeste ">celeste </option>
                        <option value="cereza">cereza</option>
                        <option value="champán">champán</option>
                        <option value="chartreuse o">chartreuse o</option>
                        <option value="cian">cian</option>
                        <option value="cobre">cobre</option>
                        <option value="color terracota">color terracota</option>
                        <option value="coral  ">coral  </option>
                        <option value="crema  ">crema  </option>
                        <option value="fucsia">fucsia</option>
                        <option value="granate ">granate </option>
                        <option value="gris">gris</option>
                        <option value="gris perla">gris perla</option>
                        <option value="gris zinc">gris zinc</option>
                        <option value="gualdo">gualdo</option>
                        <option value="hueso">hueso</option>
                        <option value="lavanda">lavanda</option>
                        <option value="lila">lila</option>
                        <option value="magenta">magenta</option>
                        <option value="marrón">marrón</option>
                        <option value="marrón chocolate">marrón chocolate</option>
                        <option value="morado">morado</option>
                        <option value="naranja">naranja</option>
                        <option value="negro">negro</option>
                        <option value="ocre">ocre</option>
                        <option value="ocre claro">ocre claro</option>
                        <option value="ocre oscuro">ocre oscuro</option>
                        <option value="oro o">oro o</option>
                        <option value="pardo">pardo</option>
                        <option value="plata  ">plata  </option>
                        <option value="púrpura">púrpura</option>
                        <option value="rojo">rojo</option>
                        <option value="rojo carmín">rojo carmín</option>
                        <option value="rojo óxido">rojo óxido</option>
                        <option value="rosa ">rosa </option>
                        <option value="rosa palo">rosa palo</option>
                        <option value="salmón  ">salmón  </option>
                        <option value="turquesa">turquesa</option>
                        <option value="verde">verde</option>
                        <option value="verde botella">verde botella</option>
                        <option value="verde esmeralda">verde esmeralda</option>
                        <option value="verde lima">verde lima</option>
                        <option value="verde manzana">verde manzana</option>
                        <option value="verde musgo">verde musgo</option>
                        <option value="verde oliva">verde oliva</option>
                        <option value="verde pistacho">verde pistacho</option>
                        <option value="aguamarina">aguamarina</option>
                        <option value="violeta">violeta</option>
                        <option value="vino">vino</option>
                      </select>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group">
                      <label for="description">Año:</label>
                      <select name="year" id="select-year">
                        <option value="null">Desconocido</option>
                        @for ($year = date('Y'); $year > date('Y') - 100; $year--)
                          <option value="{{$year}}">{{$year}}</option>
                        @endfor
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
    $('#select-brand').selectize({
      create: true,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });
    $('#select-model').selectize({
      create: true,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });
    $('#select-color').selectize({
      create: true,
      sortField: {
        field: 'text',
        direction: 'asc'
      },
      dropdownParent: 'body',
      persist: true
    });
    $('#select-year').selectize({
      create: false,
      sortField: {
        field: 'text',
        direction: 'desc'
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
              create: true,
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
          create: true,
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