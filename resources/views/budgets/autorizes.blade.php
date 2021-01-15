@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Factura')])

@section('inlinecss')
  <link rel="stylesheet" href="{{ asset('css/selectize.bootstrap2.css') }}">
@endsection

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
               <div class="card">
                  <div class="card-header card-header-info">
                     <h4 class="card-title ">{{ __('Presupuesto') }}</h4>
                     <p class="card-category">{{ $budget->id }}</p>
                  </div>

                  <div class="card-body">
                     <form action="{{ route('budgets.autorize', $budget->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                           <div class="col">
                              <select id="budget_users" name="select_alloweds[]" multiple>
                                 <option value=""></option>
                                 @foreach(\App\User::where('status', 1)->get() as $user)
                                    <option value="{{ $user->id }}" @if($budget->hasAccess($user->id)) 'selected' @endif>
                                       {{ $user->name }}
                                    </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <input class="btn btn-primary" type="submit" value="Guardar">
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @php
    $selected = $budget->usersAccess->pluck('id')->toArray();
   @endphp

@endsection

@section('inlinejs')
   <script src="{{ asset('js/selectize.js') }}"></script>
   <script>
      $(document).ready(function(){
        var selected = @json($selected);
         $('#budget_users').selectize({
          items:selected
         });
      });
   </script>
@endsection