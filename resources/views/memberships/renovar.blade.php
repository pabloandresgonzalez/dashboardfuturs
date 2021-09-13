@extends('layouts.panel')


@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-single-02"></i> Renovar membresia - {{ $memberships->membership }}</h3>
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


      <form class="row g-3" action="{{ url('membershiprenovar/'.$memberships->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')

        
         
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
            </div>
              <select id="membership" name="membership" class="form-control" >
                <option value="{{ $memberships->membership}}">{{ $memberships->membership }}</option>
                  
              </select>
          </div>
        </div> 
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
            </div>
              <select id="membership" name="membership" class="form-control" >
                <option value="{{ $memberships->membership}}">{{ $memberships->detail }}</option>
                  
              </select>
          </div>
        </div>       
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
            </div>  
            <label class="form-control">{{ $memberships->hashUSDT }}</label>                     
                         
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
            </div>  
            <label class="form-control">{{ $memberships->hashBTC }}</label>                     
                         
          </div>
        </div>
        <div class="col-md-4">
          <button type="" class="btn btn-outline-default" ><i class="ni ni-satisfied"></i> Enviar Solicitud</button>
        </div>

      </form>

      </div>
    </div>

    
  </div>
@endsection