@extends('layouts.panel')


@section('content')
        <div class="card shadow">
          <div class="card-header border-0">
            <div class="row align-items-center">
              <div class="col">
                <h1 class="mb-0">Membresías</h1>
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

          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia1.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">100 USDT</h4> 
                    <span> <p class="card-text">
                    50 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>  
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia2.PNG') }}"  alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">250 USDT</h4> 
                    <span> <p class="card-text">
                    125 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>                   
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia3.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">500 USDT</h4> 
                    <span> <p class="card-text">
                    250 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <hr class="my-3">

            <div class="container-fluid">
        <div class="header-body">

          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia4.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">1000 USDT</h4> 
                    <span> <p class="card-text">
                    500 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia5.PNG') }}"  alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">2000 USDT</h4> 
                    <span> <p class="card-text">
                    1000 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>                     
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia6.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">3000 USDT</h4> 
                    <span> <p class="card-text">
                    1500 Pts X Ref.s<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>                    
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

            <hr class="my-3">

            <div class="container-fluid">
        <div class="header-body">

          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia7.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">                    
                    <h4 class="card-title">4000 USDT</h4> 
                    <span> <p class="card-text">
                    1000 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>                   
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6">
              <div class="row">
                <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="{{ asset('img/brand/membresia6.PNG') }}" alt="Card image cap">
                  <div class="card-body" style="text-align: center;">
                    <h4 class="card-title">5000 USDT</h4> 
                    <span> <p class="card-text">
                    2500 Pts X Ref.<br></p></span><br>
                    <h5 class="card-title">5 % de Administración</h5>                    
                    <a data-toggle="modal" data-target="#modal-form" href="#" class="badge badge-warning"><i class="ni ni-cart"></i>&nbsp; Selecionar</a><br>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>

    <div class="col-md-4">

      <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          
          <div class="modal-body p-0">
              
                  
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-5">
                    <div class="text-muted text-center mt-2 mb-3"><small>Depósito USDT</small><br><br>
                      <img src="{{ asset('img/brand/qrusdt.PNG') }}">                      
                    </div> 
                </div>
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>TVDHJ4U95TJFBJng1kwPB9NxDsXCEQ4gV1</small>
                    </div>
                    <a href="/membresiasuser" class="btn btn-outline-success btn-lg btn-block"><i class="ni ni-check-bold"></i>&nbsp; Comprar</a><br>              

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


      <br>
        <hr class="my-3">
           <h5> &nbsp; &nbsp; &nbsp;De la misma forma que pagues tu paquete, así mismo será tu pago. Ejemplo: si compras con Dash tus pagos serán en Dash<br><h5/>

        <main class="py-4">
            @yield('content')
        </main>

</div>

@endsection