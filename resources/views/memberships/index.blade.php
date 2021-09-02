@extends('layouts.panel')


@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-single-02"></i> Gestíon Memberships</h3>
        </div>
        <div class="col-md-6">
          <a href="membresiasuser" class="btn btn-outline-default">
          <i class="ni ni-trophy"></i> Membresías
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


                <div class="table-responsive">
            <table class="table align-items-center table-dark">
              <thead class="thead-dark">
                <tr>
                  <th scope="col" class="sort">Nombre</th>
                  <th scope="col">user</th>
                  <th scope="col">hashUSDT</th>
                  <th scope="col">hashBTC</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Fecha Cierre</th>
                  <th scope="col">Soporte de pago</th>
                  <th scope="col">Detalle</th>
                  <th scope="col">+ Detalles</th>
                  <th scope="col">Editar</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($memberships as $membership)
                <tr>
                  <td scope="row">
                    {{ $membership->membership }}
                  </td>
                  <td>
                    {{ $membership->user }}
                  </td>
                  <td>
                    {{ $membership->hashUSDT }}
                  </td>
                  <td>
                    {{ $membership->hashBTC }}
                  </td>
                  <td>
                    {{ $membership->status }}
                  </td>
                  <td>
                    {{ $membership->closedAt }}
                  </td>
                  <td>
                    {{ $membership->image }}
                  </td>   
                  <td>
                    {{ $membership->detail }}
                  </td>                
                  <td>
                    <form action="" method="POST">
                      @csrf
                      @method('DELETE')
                      <a href="{{ url('/membership/'.$membership->id.'/edit') }}" class="btn btn-outline-secondary"><i class="ni ni-settings"></i> Editar</a>
                    </form>
                  </td>
                  <td>
                      <a href="" class="btn btn-outline-secondary"><i class="ni ni-bullet-list-67"></i> Detalle</a>
                  </td>
                </tr>
                 @endforeach
              </tbody>
            </table>


          <div class="col-md-4">
        </div>
    </div>


      </div>
    </div>
  </div>
@endsection
