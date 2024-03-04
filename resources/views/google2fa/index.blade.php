@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 70vh;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading font-weight-bold">Registro</div>
                <hr>
                @if($errors->any())
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                          <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
  
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                        {{ csrf_field() }}
  
                        <div class="form-group">
                            <p>Ingresa el <strong>OTP</strong> generado en tu aplicación de autenticación. <br> Asegúrate de enviar el código actual porque se actualiza cada 30 segundos.</p>
                            <label for="one_time_password" class="col-md-4 control-label">Contraseña de Uso Único</label>
  
                            <div class="col-md-6">
                                <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
                            </div>
                        </div>
  
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
