@extends('layouts.panel')

@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-bullet-list-67"></i> &nbsp;Detalle</h3>
        </div>
        <div class="col-md-6">
          <a href="/home" class="btn btn-outline-default">
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
                    <h3 class="mb-0"><i class="ni ni-money-coins"></i> &nbsp;Traslado de billetera</h3>
                  </div>

                  
                    <div class="card-body">
                    
                      <form class="row g-3" action="{{ url('wallet') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <?php
                          if (isset($result)) {
                  
                            if (isset($data['USDT']['total'])) {

                                //$balancecho = $data['BTC']['balance']; 
                                //$exhange = $data['BTC']['exhange']; 

                                  $total = $data['USDT']['total'];


                              if ($total > 50) {
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
                                    <h5>Es necesario tener como minimo 50 en saldo y una membresia activa para retirar.</h5>                                 
                                  </div>
                              ';
                              
                              }                                
                                                                                       
                              
                            }else {

                              echo '                                
                                  <div class="card-body">                                  
                                    <h5>Es necesario tener una membresia activa y saldo suficiente para retirar.</h5>                                 
                                  </div>
                              ';

                            }

                          }

                          ?>
                           
                    </div>

                   

                  <div class="col-md-4">
                                

                      </form>

                    
                    </div>
                  </div> 
                </div>


              </div>
            </div>
        </div>    
      </div>

      <hr style="width:75%;" />



      <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
                <div class="card pub-prestamo">
                  <div class="card-header">
                    <h3 class="mb-0"><i class="ni ni-delivery-fast"></i> &nbsp;Movimientos</h3>
                  </div>

                  
                    <div class="card-body">
                    
                      <div class="table-responsive">
            <table class="table align-items-center table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="sort">Fecha</th>
                  <th scope="col">Estado</th>
                  <th scope="col">$ Valor</th>
                  <th scope="col">Tarifa</th>
                  <th scope="col">Detalle</th>
                  <th scope="col">Tipo movimiento</th>
                  <th scope="col">Divisa</th>
                </tr>
              </thead>


              <tbody>
                @foreach ($Wallets as $Wallet)
                <tr>
                  <td scope="row">
                    {{ $Wallet->created_at }}
                  </td>
                  <td>
                    {{ $Wallet->status }}
                  </td>
                  <td>
                    {{ $Wallet->value }}
                  </td>
                  <td>
                    {{ $Wallet->fee }}
                  </td>
                  <td>
                    {{ $Wallet->detail }}
                  </td>
                  <td>
                    {{ $Wallet->type }}
                  </td>
                  <td>
                    {{ $Wallet->currency }}
                  </td>                            
                 </tr>
                 @endforeach
                </tbody>
            </table>

                    
                    </div>
                  </div> 
                </div>
                <hr style="width:50%;" />

            {{ $Wallets->appends(request()->input())->links() }}

      </div>
    </div>
  </div>
  </div>
    </div>




        <hr class="my-3"> 

@endsection