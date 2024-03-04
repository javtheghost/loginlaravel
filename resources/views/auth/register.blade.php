@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="center">
                    <form class="form id="form_login" method="POST" action="{{ route('register') }} ">
                        @csrf
                        <p class="title">Registrarse </p>
                        <p class="message">Ingresa los campos para registrarte. </p>

                        <label>
                            <input id="name" type="text" class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <span>Nombres</span>


                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </label>
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

                        <label>
                            <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                            <span>Confirmar Contraseña</span>

                        </label>



                        <button class="submit" type="submit">Registrarse</button>
                        <p class="signin">Ya tienes una cuenta? <a href="{{ route('login') }}">Clic aquí</a> </p>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
