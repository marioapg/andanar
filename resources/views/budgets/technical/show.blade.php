@extends('layouts.app', ['activePage' => 'budgets', 'titlePage' => __('Factura')])

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
                     <div id="invoice">
                        <div class="toolbar hidden-print row">

                           <div class="col">
                              <a href="{{ route('budget.technical.view.pdf', $budget->id) }}" target="_blank">
                                 <button class="btn btn-info">
                                    <i class="material-icons">chrome_reader_mode</i>
                                    Ver PDF
                                 </button>
                              </a>
                           </div>

                           <div class="col">
                              <button class="btn btn-success send-mail-popup">
                                 <i class="material-icons">email</i>
                                 Enviar email
                              </button>
                           </div>

                           <div class="col">
                              <form action="{{ route('budget.technical.status', $budget->id) }}" id="invoice-status" method="post" style="padding: 8px;">
                                 @csrf
                                 @method('put')
                                 <select class="form-control mdb-select change-invoice-select {{$budget->status}}-class" name="status" id="status" required style="border-radius: 3px; color: white;">
                                    <option value="presupuestado" {{ ($budget->status == 'presupuestado') ? ' selected' : '' }}>Presupuestado</option>
                                    <option value="rechazado" {{ ($budget->status == 'rechazado') ? ' selected' : '' }}>Rechazado</option>
                                    <option value="aceptado" {{ ($budget->status == 'aceptado') ? ' selected' : '' }}>Aceptado</option>
                                    <option value="proceso" {{ ($budget->status == 'proceso') ? ' selected' : '' }}>Proceso</option>
                                    <option value="terminado" {{ ($budget->status == 'terminado') ? ' selected' : '' }}>Terminado</option>
                                    <option value="facturado" {{ ($budget->status == 'facturado') ? ' selected' : '' }}>Facturado</option>
                                    <option value="cobrado" {{ ($budget->status == 'cobrado') ? ' selected' : '' }}>Cobrado</option>
                                 </select>
                              </form>
                           </div>
                        </div>
                        
                        <embed src="{{ route('budget.technical.view.embed', $budget->id) }}" type="application/pdf" width="100%" height="1200px" />
                        
                     </div>

                     <!-- VISTA DE ADJUNTOS -->
                     <div class="row">
                        @if( !is_null($budget->attached) )
                           @foreach( $budget->attached as $key => $value )
                              <div class="col">
                                 <a href="/images/budgets/{{ $value }}" target="_blank">
                                    <button class="btn btn-info">
                                       Adjunto {{ $key+1 }}
                                    </button>
                                 </a>
                              </div>
                           @endforeach
                        @endif
                     </div>
                     <!-- FIN VISTA DE ADJUNTOS -->

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="myModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <form action="{{ route('budget.send.mail', $budget->id) }}" method="POST">
               @csrf
               <div class="modal-header">
                  <h5 class="modal-title">
                     Enviar emails
                  </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Perito</span>
                     </div>
                     <div class="col text-left">
                        <input name="peritomail" type="text" value="{{ $budget->perito ? $budget->perito->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="peritocheck" type="checkbox" {{ $budget->perito ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Técnico</span>
                     </div>
                     <div class="col text-left">
                        <input name="tecnicomail" type="text" value="{{ $budget->technical ? $budget->technical->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="tecnicocheck" type="checkbox" {{ $budget->technical ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Cliente</span>
                     </div>
                     <div class="col text-left">
                        <input name="clientemail" type="text" value="{{ $budget->client ? $budget->client->email : '' }}" readonly="">
                     </div>
                     <div class="col text-left">
                        <input name="clientecheck" type="checkbox" {{ $budget->client ? '' : 'disabled' }}>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col text-left">
                        <span>Otros</span>
                     </div>
                     <div class="col text-left">
                        <input name="otrosmails" type="text" value="" placeholder="separe los emails con ,">
                     </div>
                     <div class="col text-left">
                        <input name="otroscheck" type="checkbox">
                     </div>
                  </div>
               </div>

               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               </div>
            </form>
         </div>
      </div>
   </div>

@endsection

@section('inlinejs')
   <script>
      $(document).ready(function(){
         $('.send-mail-popup').on('click', function(e){
            $('#myModal').modal('show');
         });
      });
   </script>
@endsection