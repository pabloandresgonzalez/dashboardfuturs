@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-bullet-list-67"></i> &nbsp;Detalle</h3>
        </div>
        <div class="col-md-6">
          <a href="{{ route('mismembership') }}" class="btn btn-outline-default">
          <i class="ni ni-bold-left"></i> Volver
          </a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
    <div class="card-body">

      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}
          </li>
          @endforeach
          <ul>
        </div>
      @endif

      <div class="container-fluid">
        <div class="header-body">
            <div class="row-fluid ">
              <div class="row">


              <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card pub-prestamo">
                  <div class="card-header">
                    <h3 class="mb-0"><i class="ni ni-single-02"></i> &nbsp;Balance - {{ $user->name }}</h3>
                  </div>

                  
                    <div class="card-body">
                    
                      <div class="list-inline-item"> 
                      <ul><h3>PSIV</h3></ul>                       
                        <ul>
                          Balance:  &nbsp;

                          <?php 

                            if ($result) {
                              $url = ($result);

                                    $data = json_decode($url, true);

                              if (isset($data['PSIV']['balance'])) {
                                
                                  $balancecho = $data['PSIV']['balance']; 

                                  echo $balancecho;
                              }else {

                                echo '*';

                              } 

                            }    

                          ?>
                          
                        </ul> 
                        <ul>
                          En canje:  &nbsp;

                          <?php 

                            if ($result) {
                              $url = ($result);

                                    $data = json_decode($url, true);

                              if (isset($data['PSIV']['exhange'])) {
                                
                                  $balancecho = $data['PSIV']['exhange']; 

                                  echo $balancecho;
                              }else {

                                echo '*';

                              } 

                            }    

                          ?>
                          
                        </ul>
                        <ul>
                          Traslados:  &nbsp;
                          <?php 
                            if ($result) {
                              $url = ($result);
                                    $data = json_decode($url, true);
                              if (isset($data['PSIV']['withdrawals'])) {
                                  $withdrawals = $data['PSIV']['withdrawals'];
                                  echo $withdrawals;
                              }else {
                                echo '*';
                              } 
                            } 
                          ?>                         
                        </ul>
                        <ul>
                          Saldo:  &nbsp;
                          <?php 
                            if ($result) {
                              $url = ($result);
                                    $data = json_decode($url, true);
                              if (isset($data['PSIV']['total'])) {
                                  $saldo = $data['PSIV']['total'];
                                  echo $saldo;
                              }else {
                                echo '*';
                              } 
                            } 
                          ?>                         
                        </ul> 

                        <hr style="width:75%;" />   

                      <ul><h3>USDT</h3></ul>                       
                        <ul>
                          Balance:  &nbsp;

                          <?php 

                            if ($result) {
                              $url = ($result);

                                    $data = json_decode($url, true);

                              if (isset($data['USDT']['balance'])) {
                                
                                  $balancecho = $data['USDT']['balance']; 

                                  echo $balancecho;
                              }else {

                                echo '*';

                              } 

                            }    

                          ?>
                          
                        </ul> 
                        <ul>
                          En canje:  &nbsp;

                          <?php 

                            if ($result) {
                              $url = ($result);

                                    $data = json_decode($url, true);

                              if (isset($data['USDT']['exhange'])) {
                                
                                  $balancecho = $data['USDT']['exhange']; 

                                  echo $balancecho;
                              }else {

                                echo '*';

                              } 

                            }    

                          ?>
                          
                        </ul>
                        <ul>
                          Traslados:  &nbsp;
                          <?php 
                            if ($result) {
                              $url = ($result);
                                    $data = json_decode($url, true);
                              if (isset($data['USDT']['withdrawals'])) {                                
                                  $withdrawals = $data['USDT']['withdrawals']; 
                                  echo $withdrawals;
                              }else {
                                echo '*';
                              } 
                            }   
                          ?>                          
                        </ul> 
                        <ul>
                          Saldo:  &nbsp;
                          <?php 
                            if ($result) {
                              $url = ($result);
                                    $data = json_decode($url, true);
                              if (isset($data['USDT']['total'])) {                                
                                  $total = $data['USDT']['total']; 
                                  echo $total;
                              }else {
                                echo '*';
                              } 
                            }   
                          ?>                          
                        </ul>                              

                      </div>
                    
                    </div>
                </div> 

              </div>

              <div class="col-xl-8 order-xl-2 mb-5 mb-xl-0">
                <div class="card pub-prestamo">
                  <div class="card-header">
                    <h3 class="mb-0"><i class="ni ni-money-coins"></i> &nbsp;Traslado de billetera para la membresia No {{ $membership->id }} de {{ $membership->membership }}</h3>
                    fecha de activacion de la membresia
                  </div>

                  
                    <div class="card-body">
                    
                      <form class="row g-3" action="{{ url('membershiptransfer') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="col-md-12" >
                              <div class="input-group input-group-alternative mb-3">
                                
                                <input hidden="true" class="form-control" placeholder="{{ $membership->activedAt }}" type="text" name="activedAt" value="{{ $membership->activedAt }}" required autocomplete="{{ $membership->activedAt }}" autofocus>
                              </div>
                            </div>
                        
                          <?php
                          if (isset($result)) {
                  
                            if (isset($data['USDT']['total']) & isset($data['PSIV']['total'])) {

                                //$balancecho = $data['BTC']['balance']; 
                                //$exhange = $data['BTC']['exhange']; 

                                  $totalPSIV = $data['PSIV']['total'];
                                  $totalUSDT = $data['USDT']['total'];


                              if ($totalUSDT > 25 || $totalPSIV > 25 & $membership->status == 'Activo') {
                                echo '

                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-money-coins"></i></span>
                                </div>
                                <input class="form-control" placeholder="Valor" type="number" name="value" value="" required autocomplete="value" autofocus>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-credit-card"></i></span>
                                </div>
                                  <select id="currency" name="currency" class="form-control" required>
                                      <option value=""  >Tipo divisa</option>
                                      <option value="PSIV"  >PSIV</option>
                                      <option value="USDT"  >USDT</option>
                                  </select>
                              </div>
                            </div> 
                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-credit-card"></i></span>
                                </div>
                                  <input class="form-control" placeholder="Dime la Wallet" type="text" name="wallet" value="" required autocomplete="wallet" autofocus>
                              </div>
                            </div>                           
                            <div class="col-md-6" >
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                </div>
                                <input class="form-control" placeholder="Detalle" type="text" name="detail" value="" required autocomplete="detail" autofocus>
                              </div>
                            </div>


                            <div class="col-md-4">
                              <button type="submit" class="btn btn-outline-default" ><i class="ni ni-satisfied"></i> Enviar Traslado</button>
                            </div>

                              ';
                              }else {

                                echo '                                
                                  <div class="card-body">                                  
                                    <h5>Es necesario que la membresia este activa para hacer un traslado.</h5>                                 
                                  </div>
                              ';
                              
                              }                                
                                                                                       
                              
                            }else {

                              echo '                                
                                  <div class="card-body">                                  
                                    <h5>Es necesario tener una membresia activa y saldo suficiente para hacer un traslado.</h5>                                 
                                  </div>
                              ';

                            }

                          }

                          ?>
                            
                    </div>
                    </form>                  
                  </div> 
                </div>


              </div>
            </div>
        </div>    
      </div>

      <br>

      <div class="col-xl-8 order-xl-2 mb-5 mb-xl-0">
                <div class="card pub-prestamo">
                  <div class="card-header">
                    <h3 class="mb-0"><i class="ni ni-money-coins"></i> &nbsp;Traslado de billetera para la membresia No {{ $membership->id }} de {{ $membership->membership }}</h3>
                    Ultimo retiro
                  </div>

                  
                    <div class="card-body">
                    
                      <form class="row g-3" action="{{ url('membershiplasttransfer') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <?php
                          if (isset($result)) {
                  
                            if (isset($data['USDT']['total']) & isset($data['PSIV']['total'])) {

                                //$balancecho = $data['BTC']['balance']; 
                                //$exhange = $data['BTC']['exhange']; 

                                  $totalPSIV = $data['PSIV']['total'];
                                  $totalUSDT = $data['USDT']['total'];


                              if ($totalUSDT > 25 || $totalPSIV > 25) {
                                echo '

                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-money-coins"></i></span>
                                </div>
                                <input class="form-control" placeholder="Valor" type="number" name="value" value="" required autocomplete="value" autofocus>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-credit-card"></i></span>
                                </div>
                                  <select id="currency" name="currency" class="form-control" required>
                                      <option value=""  >Tipo divisa</option>
                                      <option value="PSIV"  >PSIV</option>
                                      <option value="USDT"  >USDT</option>
                                  </select>
                              </div>
                            </div> 
                            <div class="col-md-6">
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-credit-card"></i></span>
                                </div>
                                  <input class="form-control" placeholder="Dime la Wallet" type="text" name="wallet" value="" required autocomplete="wallet" autofocus>
                              </div>
                            </div>                           
                            <div class="col-md-6" >
                              <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                </div>
                                <input class="form-control" placeholder="Detalle" type="text" name="detail" value="" required autocomplete="detail" autofocus>
                              </div>
                            </div>


                            <div class="col-md-4">
                              <button type="submit" class="btn btn-outline-default" ><i class="ni ni-satisfied"></i> Enviar Traslado</button>
                            </div>

                              ';
                              }else {

                                echo '                                
                                  <div class="card-body">                                  
                                    <h5>Es necesario que la membresia este activa para hacer un traslado.</h5>                                 
                                  </div>
                              ';
                              
                              }                                
                                                                                       
                              
                            }else {

                              echo '                                
                                  <div class="card-body">                                  
                                    <h5>Es necesario tener una membresia activa y saldo suficiente para hacer un traslado.</h5>                                 
                                  </div>
                              ';

                            }

                          }

                          ?>
                            
                    </div>
                    </form>                  
                  </div> 
                </div>

      <hr style="width:75%;" />


                    </div>
                  </div> 

                </div> 

                 <hr class="my-3">           
@endsection