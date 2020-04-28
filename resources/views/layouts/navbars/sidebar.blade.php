<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('TelcoGes') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="material-icons">assignment_ind</i>
          <p>{{ __('Usuarios') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">account_box</i>
                <span class="sidebar-normal">{{ __('Perfil') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <i class="material-icons">list</i>
                <span class="sidebar-normal"> {{ __('Listado de usuarios') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ ($activePage == 'invoice-send' || $activePage == 'invoice-received') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#invoices" aria-expanded="true">
          <i class="material-icons">content_paste</i>
          <p>{{ __('Facturas') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="invoices">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'invoice-send' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <i class="material-icons">call_made</i>
                <span class="sidebar-normal">{{ __('Emitidas') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'invoice-received' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <i class="material-icons">call_received</i>
                <span class="sidebar-normal"> {{ __('Recibidas') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      @if (App::environment() == 'develop')
        <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('table') }}">
            <i class="material-icons">content_paste</i>
              <p>{{ __('Table List') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('typography') }}">
            <i class="material-icons">library_books</i>
              <p>{{ __('Typography') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('icons') }}">
            <i class="material-icons">bubble_chart</i>
            <p>{{ __('Icons') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('map') }}">
            <i class="material-icons">location_ons</i>
              <p>{{ __('Maps') }}</p>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
          <a class="nav-link" href="{{ route('notifications') }}">
            <i class="material-icons">notifications</i>
            <p>{{ __('Notifications') }}</p>
          </a>
        </li>
      @endif
    </ul>
  </div>
</div>