@extends('layouts.panel')


@section('content')
<div class="card shadow">

          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h1 class="mb-0">Vitrina Membrecías</h1>
              </div>
              @if(session('message'))
                    <div class="alert alert-success">
                      {{ session('message') }}
                    </div>
              @endif

            </div>
          </div>


      <div class="container-fluid">
        <div class="header-body">
            <div class="row-fluid ">
              <div class="row">

              @foreach($membresias as $membresia)

                <!-- Card stats -->
                
                  <div class="col-xl-4 col-lg-6">
                    
                      <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('img/brand/membresia1.PNG') }}" alt="Card image cap">
                        <div class="card-body" style="text-align: center;">
                          <h3 class="card-title"></h3> 
                          <span> <p class="card-text">
                          {{ $membresia->name }}<br></p></span><br>
                          <h4 class="card-title">{{ $membresia->detail }}</h4> 
                          <h5 class="card-title">{{ $membresia->isActive }}</h5> 
                          <h5 class="card-title">Valor {{ $membresia->valor }}</h5>             
                          <a data-toggle="modal" data-target="#modal-form1-{{$membresia->id}}"  href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Pago con PSIV</a> |
                          <a data-toggle="modal" data-target="#modal-form-{{$membresia->id}}" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp;Pago con USDT</a> 
                        </div>
                      </div>
                      <hr>
                 
                  </div>




          <div class="modal fade" id="modal-form1-{{$membresia->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
          <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
              
              <div class="modal-body p-0">
                  
                      
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-5">
                        <div class="text-muted text-center mt-2 mb-3"><small>Depósito PSIV</small><br><br>
                          <img src="{{ asset('img/brand/qrpsiv.PNG') }}">                      
                        </div> 
                        <div class="text-center text-muted mb-4">
                            <small>0xeB4e247A9C0ca606aE0300218014A71A4BA93319</small>
                            <br>
                            <small>Valor {{ $membresia->valor }}</small>
                        </div>  
                        <br>
                        <div class="text-center text-muted mb-4">
                            <strong>Valor membresía + administración <br><br><?php echo $membresia->valor + $membresia->valor * 5 / 100; ?></strong>                            
                        </div>                     
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">                        

                            <div class="text-center">
                                <a type="button" href="/membership/create" class="btn btn-outline-success btn-lg btn-block"><i class="ni ni-check-bold"></i>&nbsp; Registrar Hash de pago</a>
                            </div>                                    

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="modal-form-{{$membresia->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                
                <div class="modal-body p-0">


                  <div class="card bg-secondary shadow border-0">
                          <div class="card-header bg-transparent pb-5">
                              <div class="text-muted text-center mt-2 mb-3"><small>Depósito USDT</small><br><br>
                                <img src="{{ asset('img/brand/qrusdt.PNG') }}">                      
                              </div> 
                              <div class="text-center text-muted mb-4">
                                  <small>TC5QbZxSNhCjxkhmpKk54pohjbuiXvtfbS</small>
                                  <br>
                                <small>Valor {{ $membresia->valor }}</small>
                              </div> 
                              <br>
                              <div class="text-center text-muted mb-4">
                                  <strong>Valor membresía + administración <br><br><?php echo $membresia->valor + $membresia->valor * 5 / 100; ?></strong>                            
                              </div>                     
                          </div>
                          <div class="card-body px-lg-5 py-lg-5">                        

                                  <div class="text-center">
                                      <a type="button" href="/membership/create" class="btn btn-outline-success btn-lg btn-block"><i class="ni ni-check-bold"></i>&nbsp; Registrar Hash de pago</a>
                                  </div>                                    

                          </div>
                        </div>
                                      

                  </div>
                </div>
              </div>
            </div>
    


              @endforeach

            
        </div>
      </div>
    </div>



  </div>
</div>

  <br>
        <hr class="my-3">
           <h5 style="text-align: center;"> &nbsp; De la misma forma que pagues tu paquete, así mismo será tu pago. Ejemplo: si compras con USDT tus pagos serán en USDT<br><h5/>

        <main class="py-4">
            @yield('content')
        </main>


@endsection