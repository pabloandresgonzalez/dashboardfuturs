@extends('layouts.panel')


@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-single-02"></i> Hash de pago - {{ $memberships->user_email }}</h3>
        </div>
        <div class="col-md-6">
          <a href="/membership" class="btn btn-outline-default">
          <i class="ni ni-bold-left"></i> Cancelar y volver
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


      <form class="row g-3" action="{{ url('membership/'.$memberships->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')

        
         
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
            </div>
              <select id="membership" name="membership" class="form-control" >
                <option value="{{ $memberships->membership}}">{{ $memberships->membership}}</option>
                  
              </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-image"></i>&nbsp;Solo archivo de imagen</span>
            </div>
            <input class="form-control" placeholder="image"  type="file" name="image"  autocomplete="image" autofocus>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
            </div>  
            <label class="form-control">{{ $memberships->hashUSDT}}</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
            </div>  
            <label class="form-control">{{ $memberships->hashPSIV }}</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-active-40"></i></span>
            </div>
              <select id="status" name="status" class="form-control" required>
                <option value="{{ $memberships->status}}">{{ $memberships->status}}</option>
                  <option value="Activo"  >Activo</option>
                  <option value="Cerrado"  >Cerrado</option>                  
              </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
            </div>                     
            <input class="form-control" placeholder="Detalle" type="text" name="detail" value="{{ $memberships->detail}}" autocomplete="detail" autofocus>             
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
            </div>                    
            <input class="form-control" placeholder="Ej. <?php echo $fecha_actual; ?>" type="text" name="activedAt" value="{{ $memberships->activedAt}}" autocomplete="activedAt" autofocus>             
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
            </div>                    
            <input class="form-control" placeholder="Ej. <?php echo $fecha_actual; ?>" type="text" name="closedAt" value="{{ $memberships->closedAt}}" autocomplete="closedAt" autofocus>             
          </div>
        </div>
        
        <div class="col-md-4">
          <button type="" class="btn btn-outline-default" ><i class="ni ni-satisfied"></i> Enviar</button>
        </div>


      </form>

      </div>
    </div>

    
  </div>
@endsection





