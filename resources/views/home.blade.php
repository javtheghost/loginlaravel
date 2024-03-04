@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->rol == 'Administrador')

                    <h2 class="text-sm ">¡Bienvenido administrador! <br>{{Auth::user()->name}} </h2>
                        

                    @else
                    <h2 class="text-sm ">¡Bienvenido! <br>{{Auth::user()->name}} </h2>


                    @endif
        </div>
    </div>
</div>
@endsection
