<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>{{ config('app.name') }}</title>
  <!-- Favicon -->
  <link href="{{ asset('img/brand/iconfuturs.PNG') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <!-- Argon CSS -->
  <link href="{{ asset('css/argon.css?v=1.0.0') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



  <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").fadeOut(40000);
        });
    });
  </script>

  <?php 

    $url = ("https://blockchain.info/ticker");
        $data = json_decode(file_get_contents($url), true);

        $data ['USD']['last'];
        

  ?>
  <?php

  $user = \Auth::user();

          $id = $user->id;

          $datacurl = [
          'userId' => $id,
          'token' => 'AcjAa76AHxGRdyTemDb2jcCzRmqpWN'
          ];

          $curl = curl_init();

          curl_setopt_array($curl, array(
              CURLOPT_URL => "https://sd0fxgedtd.execute-api.us-east-2.amazonaws.com/Prod_getBalanceByUser",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30000,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($datacurl),        
              CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                  "accept: */*",
                  "accept-language: en-US,en;q=0.8",
                  "content-type: application/json",
              ),
          ));

          $result = curl_exec($curl);
          $err = curl_error($curl);

          //dd($err);

          //dd($result);
          curl_close($curl);

          //decodificar JSON porque esa es la respuesta
          $respuestaDecodificada = json_decode($result);
 
?>

  
  @yield('styles')
</head>

<body> 
  <!-- Sidenav -->
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="/">
        <img src="{{ asset('img/brand/iconfuturs.PNG') }}" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                
                  @include('includes.avatar')
                
              </span>
            </div>
          </a>
          @include('includes.panel.dropdown_menu')
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="/">
                <img src="{{ asset('img/brand/iconfuturs.PNG') }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
          @include('includes.panel.menu')
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
          <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#">Panel</a>

          <!-- partial:index.partial.html -->
          <div class="slider">
          <div class="slide-track">
          <div class="slide">
          ARS/(USD)<?php echo $data ['ARS']['last'];?>
          </div>
          <div class="slide">
          AUD/(USD)<?php echo $data ['AUD']['last'];?>
          </div>
          <div class="slide">
          BRL/(USD)<?php echo $data ['BRL']['last'];?>
          </div>
          <div class="slide">
          CAD/(USD)<?php echo $data ['CAD']['last'];?>
          </div>
          <div class="slide">
          CHF/(USD)<?php echo $data ['CHF']['last'];?>
          </div>
          <div class="slide">
          CLP/(USD)<?php echo $data ['CLP']['last'];?>
          </div>
          <div class="slide">
          CNY/(USD)<?php echo $data ['CNY']['last'];?>
          </div>
          <div class="slide">
          CZK/(USD)<?php echo $data ['CZK']['last'];?>
          </div>
          <div class="slide">
          DKK/(USD)<?php echo $data ['DKK']['last'];?>
          </div>
          <div class="slide">
          EUR/(USD)<?php echo $data ['EUR']['last'];?>
          </div>
          <div class="slide">
          GBP/(USD)<?php echo $data ['GBP']['last'];?>
          </div>
          <div class="slide">
          HKD/(USD)<?php echo $data ['HKD']['last'];?>
          </div>
          <div class="slide">
          HRK/(USD)<?php echo $data ['HRK']['last'];?>
          </div>
          <div class="slide">
          HUF/(USD)<?php echo $data ['HUF']['last'];?>
          </div>
          <div class="slide">
          TWD/(USD)<?php echo $data ['TWD']['last'];?>
          </div>
          <div class="slide">
          INR/(USD)<?php echo $data ['INR']['last'];?>
          </div>
          <div class="slide">
          ISK/(USD)<?php echo $data ['ISK']['last'];?>
          </div>
          <div class="slide">
          JPY/(USD)<?php echo $data ['JPY']['last'];?>
          </div>
          <div class="slide">
          KRW/(USD)<?php echo $data ['KRW']['last'];?>
          </div>
          <div class="slide">
          NZD/(USD)<?php echo $data ['NZD']['last'];?>
          </div>
          <div class="slide">
          PLN/(USD)<?php echo $data ['PLN']['last'];?>
          </div> 
          <div class="slide">
          RON/(USD)<?php echo $data ['RON']['last'];?>
          </div>
          <div class="slide">
          RUB/(USD)<?php echo $data ['RUB']['last'];?>
          </div>
          <div class="slide">
          SEK/(USD)<?php echo $data ['SEK']['last'];?>
          </div>
          <div class="slide">
          SGD/(USD)<?php echo $data ['SGD']['last'];?>
          </div>
          <div class="slide">
          THB/(USD)<?php echo $data ['THB']['last'];?>
          </div>
          <div class="slide">
          BTC/(USD)<?php echo $data ['USD']['last'];?>
          </div>

          </div>
          </div>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
              <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                <a class="dropdown-item" href="#">Notificaciones</a>
              </div>
            </li>
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  
                  @include('includes.avatar')
                
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                </div>
                </div>
              </a>
              @include('includes.panel.dropdown_menu')
            </li>
          </ul>
        </div>
      </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary-dorado pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">BTC | (USD)</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $data ['USD']['last'];?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fab fa-bitcoin"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fas fa-dollar-sign"></i></span>
                    <span class="text-nowrap"> <?php echo $data ['USD']['last'];?></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">My Users</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $totalusers;  ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-danger mr-2"><i class="fas fa-arrow-up"></i> Registered Users</span>
                    <span class="text-nowrap"></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Histórico de producción </h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo "$ " . $totalProduction;  ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="ni ni-calendar-grid-58"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="ni ni-calendar-grid-58 text-info"></i></span>
                    <span class="text-nowrap"> Durante su permanencia </span>
                  </p>
                </div>
              </div>
            </div>          
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Histórico comisiones venta directa y renovación</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo "$ " . $totalCommission;  ?></span>                      
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-warning mr-2"><i class="ni ni-chart-bar-32 text-yellow"></i></span>
                    <span class="text-nowrap"> Durante su permanencia </span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Saldo disponible</h5>
                      <span class="h2 font-weight-bold mb-0">
                      <?php  
                        if ($result) {
                          $url = ($result);

                                $datacurl = json_decode($url, true);

                          if (isset($datacurl['PSIV']['balance'])) {
                            
                              $saldo = $datacurl['PSIV']['total']; 

                              echo "<h6>PSIV</h6> $ " . $saldo . "<br>";
                          }else {

                            echo '$ ';

                          } 

                        }

                        if ($result) {
                          $url = ($result);

                                $datacurl = json_decode($url, true);

                          if (isset($datacurl['USDT']['balance'])) {
                            
                              $saldo = $datacurl['USDT']['total']; 

                              echo "<h6>USDT</h6> $ " . $saldo  ;
                          }else {

                            echo '$ ';

                          } 

                        } 
                      ?>
                      </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i></span>
                    <span class="text-nowrap"></span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      @yield('content')
      @include('includes.panel.footer')
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Optional JS -->
  <script src="{{ asset('vendor/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/dist/Chart.extension.js') }}"></script>
  @yield('scripts')
  <!-- Argon JS -->
  <script src="{{ asset('js/argon.js?v=1.0.0') }}"></script>  
</body>

</html>