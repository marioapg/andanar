<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      {{ __('Andanar') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      @if(auth()->user()->hasRole('admin'))
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
          <i class="material-icons">account_circle</i>
          <p>{{ __('Usuarios') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'clients') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('clients.index') }}">
          <i class="material-icons">assignment_ind</i>
          <p>{{ __('Clientes') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'cars') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('cars.index') }}">
          <i class="material-icons">directions_car</i>
          <p>{{ __('Autos') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item {{ ($activePage == 'budgets') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('budget.index') }}">
          <i class="material-icons">content_paste</i>
          <p>{{ __('Presupuestos') }}
          </p>
        </a>
      </li>
    </ul>
  </div>
</div>