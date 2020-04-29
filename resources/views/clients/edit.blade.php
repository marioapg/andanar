@extends('layouts.app', ['activePage' => 'client', 'titlePage' => __('Cliente')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form class="form" method="POST" action="{{ route('client.update') }}">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Cliente') }}</h4>
                <p class="card-category">{{ __('Información de cliente') }}</p>
              </div>

              <div class="card-body ">
            <p class="card-description text-center">{{-- __('Or Be Classical') --}}</p>
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="{{ __('Nombre...') }}" value="{{ $client->name }}" required>
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
            <div class="bmd-form-group{{ $errors->has('nif') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">fingerprint</i>
                  </span>
                </div>
                <input type="text" name="nif" id="nif" class="form-control" placeholder="{{ __('NIF...') }}" value="{{ $client->nif }}" required>
              </div>
              @if ($errors->has('nif'))
                <div id="nif-error" class="error text-danger pl-3" for="nif" style="display: block;">
                  <strong>{{ $errors->first('nif') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('type') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">gavel</i>
                  </span>
                </div>
                
                <div class="form-check form-check-radio form-check-inline">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="type" id="radioperson" value="person" {{ ($client->type == 'person') ? ' checked' : '' }}> Persona
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                  </label>
                </div>
                <div class="form-check form-check-radio form-check-inline">
                  <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="type" id="radiobussiness" value="business" {{ ($client->type == 'business') ? ' checked' : '' }}> Empresa
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                  </label>
                </div>

              </div>
              @if ($errors->has('type'))
                <div id="type-error" class="error text-danger pl-3" for="type" style="display: block;">
                  <strong>{{ $errors->first('type') }}</strong>
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
                <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('Dirección...') }}" value="{{ $client->address }}" required>
              </div>
              @if ($errors->has('address'))
                <div id="address-error" class="error text-danger pl-3" for="address" style="display: block;">
                  <strong>{{ $errors->first('address') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('population') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">room</i>
                  </span>
                </div>
                <input type="text" name="population" id="population" class="form-control" placeholder="{{ __('Población...') }}" value="{{ $client->population }}" required>
              </div>
              @if ($errors->has('population'))
                <div id="population-error" class="error text-danger pl-3" for="population" style="display: block;">
                  <strong>{{ $errors->first('population') }}</strong>
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
                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="{{ __('Código postal...') }}" value="{{ $client->postal_code }}" required>
              </div>
              @if ($errors->has('postal_code'))
                <div id="postal_code-error" class="error text-danger pl-3" for="postal_code" style="display: block;">
                  <strong>{{ $errors->first('postal_code') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('province') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">map</i>
                  </span>
                </div>
                <input type="text" name="province" id="province" class="form-control" placeholder="{{ __('Provincia...') }}" value="{{ $client->province }}" required>
              </div>
              @if ($errors->has('province'))
                <div id="province-error" class="error text-danger pl-3" for="province" style="display: block;">
                  <strong>{{ $errors->first('province') }}</strong>
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
                <input type="text" name="country" id="country" class="form-control" placeholder="{{ __('España') }}" value="{{ $client->country }}" readonly="" required>
              </div>
              @if ($errors->has('country'))
                <div id="country-error" class="error text-danger pl-3" for="country" style="display: block;">
                  <strong>{{ $errors->first('country') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('commercial_name') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">business</i>
                  </span>
                </div>
                <input type="text" name="commercial_name" id="commercial_name" class="form-control" placeholder="{{ __('Nombre comercial...') }}" value="{{ $client->commercial_name }}">
              </div>
              @if ($errors->has('commercial_name'))
                <div id="commercial_name-error" class="error text-danger pl-3" for="commercial_name" style="display: block;">
                  <strong>{{ $errors->first('commercial_name') }}</strong>
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
                <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Teléfono...') }}" value="{{ $client->phone }}">
              </div>
              @if ($errors->has('phone'))
                <div id="phone-error" class="error text-danger pl-3" for="phone" style="display: block;">
                  <strong>{{ $errors->first('phone') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('celphone') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">mobile_screen_share</i>
                  </span>
                </div>
                <input type="text" name="celphone" id="celphone" class="form-control" placeholder="{{ __('Celular...') }}" value="{{ $client->celphone }}">
              </div>
              @if ($errors->has('celphone'))
                <div id="celphone-error" class="error text-danger pl-3" for="celphone" style="display: block;">
                  <strong>{{ $errors->first('celphone') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('website') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">web</i>
                  </span>
                </div>
                <input type="text" name="website" id="website" class="form-control" placeholder="{{ __('Web...') }}" value="{{ $client->website }}">
              </div>
              @if ($errors->has('website'))
                <div id="website-error" class="error text-danger pl-3" for="website" style="display: block;">
                  <strong>{{ $errors->first('website') }}</strong>
                </div>
              @endif
            </div>


          </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection