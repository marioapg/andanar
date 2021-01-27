@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Perfil usuario')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('user.update', ['id' => $user->id]) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-info">
                <h4 class="card-title">{{ __('Editar') }}</h4>
                <p class="card-category">{{ __('Información de usuario') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Nombre') }}" value="{{ old('name', $user->name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', $user->email) }}" readonly="" required />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Teléfono') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="phone" value="{{ old('phone', $user->phone) }}" />
                      @if ($errors->has('phone'))
                        <span id="phone-error" class="error text-danger" for="input-phone">{{ $errors->first('phone') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Compañia') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('company') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" name="company" id="input-company" type="text" value="{{ old('company', $user->company) }}" />
                      @if ($errors->has('company'))
                        <span id="company-error" class="error text-danger" for="input-company">{{ $errors->first('company') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Tipo usuario') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                      <select name="type" class="form-control mdb-select" placeholder="{{ __('Tipo...') }}" value="{{ old('type') }}" required>
                        @if( auth()->user()->hasRole('admin') )
                          <option value="technical" @if($user->type == 'technical') selected @endif>Técnico</option>
                        @endif
                        <option value="proficient" @if($user->type == 'proficient') selected @endif>Perito</option>
                        <option value="boss" @if($user->type == 'boss') selected @endif>Responsable</option>
                      </select>
                      @if ($errors->has('type'))
                        <span id="type-error" class="error text-danger" for="input-type">{{ $errors->first('type') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @if( auth()->user()->hasRole('admin') )
                  <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Estatus') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                        <select name="status" class="form-control mdb-select" placeholder="{{ __('Tipo...') }}" value="{{ old('status') }}" required>
                          <option value="1" @if($user->status == 1) selected @endif>Activo</option>
                          <option value="0" @if($user->status == 'proficient') selected @endif>Inactivo</option>
                        </select>
                        @if ($errors->has('status'))
                          <span id="status-error" class="error text-danger" for="input-status">{{ $errors->first('status') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                @endif

              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-info">{{ __('Actualizar') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      @if( auth()->user()->hasRole('admin') )
        <div class="row">
          <div class="col-md-12">
            <form method="post" action="{{ route('user.updatepass', ['id' => $user->id]) }}" class="form-horizontal">
              @csrf
              @method('put')

              <div class="card ">
                <div class="card-header card-header-info">
                  <h4 class="card-title">{{ __('Cambiar contraseña') }}</h4>
                  <p class="card-category">{{ __('Contraseña') }}</p>
                </div>
                <div class="card-body ">
                  @if (session('status_password'))
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                          </button>
                          <span>{{ session('status_password') }}</span>
                        </div>
                      </div>
                    </div>
                  @endif
                  <div class="row">
                    <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Contraseña actual') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Contraseña actual') }}" value="" required />
                        @if ($errors->has('old_password'))
                          <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('old_password') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label" for="input-password">{{ __('Nueva contraseña') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Ingrese la nueva contraseña') }}" value="" required />
                        @if ($errors->has('password'))
                          <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirmación') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group">
                        <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirme la nueva contraseña') }}" value="" required />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ml-auto mr-auto">
                  <button type="submit" class="btn btn-info">{{ __('Change password') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection