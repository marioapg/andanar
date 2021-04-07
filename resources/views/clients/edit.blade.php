@extends('layouts.app', ['activePage' => 'clients', 'titlePage' => __('Cliente')])

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

          <div class="card ">
            <div class="card-header card-header-info">
              <h4 class="card-title">{{ __('Cliente') }}</h4>
              <p class="card-category">{{ __('Información de cliente') }}</p>
            </div>

            @if ( auth()->user()->hasRole('admin') )
              <div>
                <form action="{{ route('client.delete', ['id' => $client->id]) }}" method="POST" onsubmit="return confirm('Realmente desea eliminar a cliente {{ $client->name }}?');">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-success btn-link" style="float: inline-end;">
                    <i class="material-icons" style="color: red;">delete_forever</i>
                  </button>
                </form>
              </div>
            @endif

            <div class="card-body ">
              <form class="form" method="POST" action="{{ route('client.update') }}">
                @csrf
                @method('put')
                <p class="card-description text-center">{{-- __('Or Be Classical') --}}</p>
                <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                          <i class="material-icons">face</i>
                      </span>
                    </div>
                    <input type="text" name="name" class="form-control" placeholder="{{ __('Nombre...') }}" value="{{ $client->name }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('name'))
                    <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                      <strong>{{ $errors->first('name') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">email</i>
                      </span>
                    </div>
                    <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ $client->email }}" readonly="">
                  </div>
                  @if ($errors->has('email'))
                    <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                      <strong>{{ $errors->first('email') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('document') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">fingerprint</i>
                      </span>
                    </div>
                    <input type="text" name="document" id="document" class="form-control" placeholder="{{ __('CIF/NIF/DNI...') }}" value="{{ $client->document }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('document'))
                    <div id="document-error" class="error text-danger pl-3" for="document" style="display: block;">
                      <strong>{{ $errors->first('document') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('address') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">house</i>
                      </span>
                    </div>
                    <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('Dirección...') }}" value="{{ $client->address }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('address'))
                    <div id="address-error" class="error text-danger pl-3" for="address" style="display: block;">
                      <strong>{{ $errors->first('address') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('postal_code') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">post_add</i>
                      </span>
                    </div>
                    <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="{{ __('Código postal...') }}" value="{{ $client->postal_code }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('postal_code'))
                    <div id="postal_code-error" class="error text-danger pl-3" for="postal_code" style="display: block;">
                      <strong>{{ $errors->first('postal_code') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('city') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">room</i>
                      </span>
                    </div>
                    <input type="text" name="city" id="city" class="form-control" placeholder="{{ __('Ciudad...') }}" value="{{ $client->city }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('city'))
                    <div id="city-error" class="error text-danger pl-3" for="city" style="display: block;">
                      <strong>{{ $errors->first('city') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('state') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">map</i>
                      </span>
                    </div>
                    <input type="text" name="state" id="state" class="form-control" placeholder="{{ __('Estado...') }}" value="{{ $client->state }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('state'))
                    <div id="state-error" class="error text-danger pl-3" for="state" style="display: block;">
                      <strong>{{ $errors->first('state') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('responsable') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">supervised_user_circle</i>
                  </span>
                </div>
                <input type="text" name="responsable" id="responsable" class="form-control" value="{{ $client->responsable ?? '' }}" placeholder="{{ __('Responsable...') }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
              </div>
              @if ($errors->has('responsable'))
                <div id="responsable-error" class="error text-danger pl-3" for="responsable" style="display: block;">
                  <strong>{{ $errors->first('responsable') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('contact_responsable') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="text" name="contact_responsable" id="contact_responsable" class="form-control" value="{{ $client->contact_responsable ?? '' }}" placeholder="{{ __('Contacto Responsable...') }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
              </div>
              @if ($errors->has('contact_responsable'))
                <div id="contact_responsable-error" class="error text-danger pl-3" for="contact_responsable" style="display: block;">
                  <strong>{{ $errors->first('contact_responsable') }}</strong>
                </div>
              @endif
            </div>
                <div class="bmd-form-group{{ $errors->has('country') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">outlined_flag</i>
                      </span>
                    </div>
                    <input type="text" name="country" id="country" class="form-control" placeholder="{{ __('País') }}" value="{{ $client->country }}" required @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('country'))
                    <div id="country-error" class="error text-danger pl-3" for="country" style="display: block;">
                      <strong>{{ $errors->first('country') }}</strong>
                    </div>
                  @endif
                </div>
                <div class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">contact_phone</i>
                      </span>
                    </div>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Teléfono...') }}" value="{{ $client->phone }}" @if(!auth()->user()->hasRole('admin') && ($client->created_by !== auth()->user()->id)) readonly @endif>
                  </div>
                  @if ($errors->has('phone'))
                    <div id="phone-error" class="error text-danger pl-3" for="phone" style="display: block;">
                      <strong>{{ $errors->first('phone') }}</strong>
                    </div>
                  @endif
                </div>
                @if ( auth()->user()->hasRole('admin') || ($client->created_by === auth()->user()->id) )
                  <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-info">{{ __('Actualizar') }}</button>
                  </div>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection