@extends('layouts.panel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3 class="mb-0">Escritorio</h3>
                </div>

                <div class="card-body">

                    @if(session('message'))
                        <div class="alert alert-success">
                          {{ session('message') }}
                        </div>
                    @endif
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Hola!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
