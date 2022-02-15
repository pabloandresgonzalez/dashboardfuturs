<h6 class="navbar-heading text-muted"> Gestionar cuenta </h6>
@if(Auth::user()->role == 'admin' || Auth::user()->role == 'user')
<hr class="my-3">
  <ul class="navbar-nav">
@endif

@if(Auth::user()->role == 'admin')
  @include('includes.panel.menu.admin')
@else
  @include('includes.panel.menu.user')
@endif
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
        <i class="ni ni-button-power text-yellow "></i> Cerrar sesión
      </a>
      <form action="{{ route('logout') }}" method="POST" style="display: none;" id="formLogout">
        @csrf

      </form>
    </li>
  </ul>
  <hr class="my-3">
  @if(Auth::user()->role == 'admin')
  <h6 class="navbar-heading text-muted">Soporte</h6>
  <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
      <a class="nav-link" href="https://wa.me/593987347130?text=%20Hola! %20Requiero%20de%20su%20ayuda%20para%20un%20soporte%20en%20FUTURS,%20Gracias">
        <i class="ni ni-support-16 text-info"></i> Ayuda
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="https://wa.me/593987347130?text=%20Hola! %20quiero%20ponerme%20en%20contacto%20con%20FUTURS,%20Gracias">
        <i class="ni ni-chat-round text-primary"></i> Contacto
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="ni ni-hat-3 text-danger"></i> Centro de apoyo
      </a>
    </li>
  </ul>
  <hr class="my-3">
  <h6 class="navbar-heading text-muted">Resportes</h6>
  <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-chart-bar-32 text-yellow"></i> Frecuencia
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="ni ni-archive-2 text-danger"></i> Historial
      </a>
    </li>
  </ul>
  @else
  <h6 class="navbar-heading text-muted">Soporte</h6>
  <ul class="navbar-nav mb-md-3">
    <li class="nav-item">
      <a class="nav-link" href="https://wa.me/593987347130?text=%20Hola! %20Requiero%20de%20su%20ayuda%20para%20un%20soporte%20en%20FUTURS,%20Gracias">
        <i class="ni ni-support-16 text-info"></i> Ayuda
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="https://wa.me/593987347130?text=%20Hola! %20quiero%20ponerme%20en%20contacto%20con%20FUTURS,%20Gracias">
        <i class="ni ni-chat-round text-primary"></i> Contacto
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="ni ni-hat-3 text-danger"></i> Centro de apoyo
      </a>
    </li>
  </ul>
  @endif

