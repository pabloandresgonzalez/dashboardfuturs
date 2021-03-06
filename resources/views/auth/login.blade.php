@extends('layouts.form')



@section('content')
<div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ $errors->first() }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>x</span>
                        </button>
                    </div>
                @else
                    <div class="text-center text-muted mb-4">
                        <small></small>
                    </div>
                @endif

              <form role="form" method="POST" action="{{ route('login') }}">
                @csrf


                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Contraseña" type="password" name="password" required autocomplete="current-password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" type="checkbox" name="" value="1" id="flexCheckDefault" onchange="javascript:showContent()">
                  <label class="custom-control-label" for="flexCheckDefault">
                     <a href="{{ route('consulta') }}" class="text-muted" target="_blank">
                    Acepto los Términos y condiciones</a>
                  </label>
                </div>

                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input name="remember" class="custom-control-input" id=" remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for=" remember">
                    <span class="text-muted">Recordar sesión</span>
                  </label>
                </div>

                <div class="text-center" id="content" style="display: none;"><br>
                  <button type="submit" id="btn" class="btn btn-outline-default">Ingresar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="{{ route('password.request') }}" class="text-light">
                <small>¿Olvidaste tu contraseña?</small>
              </a>
            </div>
            <div class="col-6 text-right">
              <a href="{{ route('register') }}" class="text-light">
                <small>¿Aun no te has registrado?</small>
            </a>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
