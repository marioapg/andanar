@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('Perfil usuario')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form id="user-create" class="form" method="POST" action="{{ route('user.create') }}">
            @csrf

           @if( Session::has('flash_message') )
              <div class="alert {{ Session::get('flash_type') }} alert-dismissible fade show" role="alert">
                {{ Session::get('flash_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            <div class="card ">
              <div class="card-header card-header-warninginfo">
                <h4 class="card-title">{{ __('Crear usuario') }}</h4>
                <p class="card-category">{{ __('Información de usuario') }}</p>
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
                <input type="text" name="name" class="form-control" placeholder="{{ __('Nombre...') }}" value="{{ old('name') }}" required>
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
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">phone</i>
                  </span>
                </div>
                <input type="text" name="phone" class="form-control" placeholder="{{ __('Teléfono...') }}" value="{{ old('phone') }}" required>
              </div>
              @if ($errors->has('phone'))
                <div id="phone-error" class="error text-danger pl-3" for="phone" style="display: block;">
                  <strong>{{ $errors->first('phone') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('type') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">add_task</i>
                  </span>
                </div>
                <select name="type" class="form-control mdb-select" id="user-type" required>
                  @if(auth()->user()->hasRole('admin'))
                    <option value="technical">Técnico</option>
                  @endif
                  <option value="proficient">Perito</option>
                  <option value="boss">Encargado</option>
                </select>
              </div>
              @if ($errors->has('type'))
                <div id="type-error" class="error text-danger pl-3" for="type" style="display: block;">
                  <strong>{{ $errors->first('type') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" @if(!auth()->user()->hasRole('admin')) disabled @endif>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmación password...') }}" @if(!auth()->user()->hasRole('admin')) disabled @endif>
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>
            {{--
            <div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="policy" name="policy" {{ old('policy', 1) ? 'checked' : '' }} >
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
                {{ __('I agree with the ') }} <a href="#">{{ __('Privacy Policy') }}</a>
              </label>
            </div>
            --}}
          </div>

              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-info">{{ __('Crear') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('inlinejs')
<script>
  $(document).ready(function(){
    $('#user-type').on('change', function(e){
      if ( $(this).val() != 'technical' ) {
        $('#password').attr('disabled', 'true');
        $('#password').val('');
        $('#password').css('background-color', '#80808040');
        $('#password_confirmation').val('');
        $('#password_confirmation').attr('disabled', 'true');
        $('#password_confirmation').css('background-color', '#80808040');
        return;
      }
      $('#password').attr('disabled', false);
      $('#password').css('background-color', '#ffffff');
      $('#password_confirmation').attr('disabled', false);
      $('#password_confirmation').css('background-color', '#ffffff');
    });
  });
</script>
@endsection