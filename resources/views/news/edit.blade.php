@extends('layouts.panel')


@section('content')
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><i class="ni ni-ruler-pencil"></i> Editar Noticia - {{ $news->title }}</h3>
        </div>
        <div class="col-md-6">
          <a href="/news" class="btn btn-outline-default">
          <i class="ni ni-bold-left"></i> Cancelar y volver
          </a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
    <div class="card-body">

      @if($errors->any())
        <div class="alert alert-danger  alert-dismissible" role="alert">
          <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}
            <button type="button" class="close" data-dismiss="alert">
                <span>x</span>
            </button>
          </li>
          @endforeach
          <ul>
        </div>
      @endif


      <form class="row g-3" action="{{ url('news/'.$news->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')



        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
            </div>
            <input class="form-control" placeholder="Titulo" type="text" name="title" value="{{ old('title', $news->title) }}" required autocomplete="title" autofocus>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-single-copy-04"></i></span>
            </div>
            <input class="form-control" placeholder="Intro" type="text" name="intro" value="{{ old('intro', $news->intro) }}" required autocomplete="intro" autofocus>
         </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
            </div>
            <input class="form-control" placeholder="Detalle" type="text" name="detail" value="{{ old('detail', $news->detail) }}" required autocomplete="detail" autofocus>
         </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-tag"></i></span>
            </div>
            <input class="form-control" placeholder="URL del video" type="text" name="url_video" value="{{ old('url_video', $news->url_video) }}" autocomplete="url_video" autofocus>
         </div>
        </div>
        <div class="col-md-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-active-40"></i></span>
            </div>
              <select id="isActive" name="isActive" class="form-control" required>
                <option value="{{ $news->isActive}}">Estado actual
                  @if($news->isActive == 1)
                    Activa
                  @elseif($news->isActive == 0)
                    Cerrada
                </option>
                  @endif
                  <option value="1"  >Activa</option>
                  <option value="0"  >Cerrada</option>
                  
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


        <div class="col-md-4">
          <button type="submit" class="btn btn-outline-default" ><i class="ni ni-satisfied"></i> &nbsp;Editar nocia</button>
        </div>



      </form>

      </div>
    </div>
  </div>
@endsection