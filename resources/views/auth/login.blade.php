@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="center">
                    <form class="form id="form_login" method="POST" action="{{ route('login') }} ">
                        @csrf
                        <p class="title">Iniciar Sesión </p>
                        <p class="message">Ingresa los campos para poder iniciar sesión. </p>



                        <label>
                            <input id="email" type="email" class="input" @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span>Correo Electrónico</span>


                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </label>

                        <label>
                            <input id="password" type="password" class="input" @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">
                            <span>Contraseña</span>

                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </label>
                                    <!--RECAPTCHA -->

                        <div class="form-group mt-3">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}

                        <!--ERROR RECAPTCHA VALIDACION -->

                            @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong style="color: rgb(212, 71, 71)" class=" tex-sm">{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                        </div>






                        <button class="submit" type="submit">Iniciar Sesión</button>
                        <p class="signin">No tienes una cuenta? <a href="{{ route('register') }}">Clic aquí</a> </p>
                    </form>
                </div>

            </div>

        </div>
    </div>
    </div>
@endsection
