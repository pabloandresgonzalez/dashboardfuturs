@extends('layouts.panel')


@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-bullet-list-67"></i> &nbsp;Historial de pagos</h3>
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


      <div class="card pub-prestamo">
        <div class="card-header">
          <i class="ni ni-money-coins"></i> &nbsp;Detalle pagos de producción
          <p style="text-align: right;">Producción: <strong><?php echo $totalProdMember ?></strong></p>
        </div>
       
          <div class="table-responsive">
            <table class="table align-items-center table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="sort">Membresia</th>
                  <th scope="col">Fecha de pago</th>
                  <th scope="col">$ Monto</th>
                  <th scope="col">Detalle</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Tipo</th>
                </tr>
              </thead>


              <tbody>
                @foreach ($networktransactions as $networktransaction)
                <tr>
                  <td scope="row">
                    {{ $networktransaction->userMembership }}
                  <td>
                    {{ $networktransaction->created_at }}
                  </td>
                  </td>
                  <td>
                    {{ $networktransaction->value }}
                  </td>
                  <td>
                    {{ $networktransaction->detail }}                    
                  </td>  
                  <td>
                    {{ $networktransaction->status}}                    
                  </td> 
                  <td>
                    {{ $networktransaction->type }}                    
                  </td>           
                 </tr>
                 @endforeach
            </table>
            <br>            
                 

    </div>
  </div> 

    <hr>

    </div>
  </div>
</div>
@endsection
