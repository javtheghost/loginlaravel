<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;

use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers {
        register as registration;
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Validador para los campos de registro
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Determinar el rol del usuario (Administrador si es el primer usuario)
        $rol = User::count() === 0;

        // Log para registrar el nuevo usuario
        Log::info('Nuevo usuario registrado: ' . $data['email']);

        // Crear y retornar un nuevo usuario
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'] ?? null, 
            'rol' => $rol ? 'Administrador' : 'Usuario',
        ]);
    }

    /**
     * Handle registration requests after a successful validation and before redirecting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Verificar si el usuario es un administrador
        $isAdmin = User::count() === 0;

        // Determinar el rol del usuario (Administrador si es el primer usuario)
        $rol = $isAdmin ? 'Administrador' : 'Usuario';

        // Si el rol es Usuario, usar el método de registro predeterminado
        if ($rol == 'Usuario') {
            $this->registration($request);
            return view('home');
        } else {
            // Si el rol es Administrador, validar y preparar para la autenticación de dos factores

            // Validar los datos del formulario de registro
            $this->validator($request->all())->validate();

            // Generar la clave secreta de Google 2FA
            $google2fa = app('pragmarx.google2fa');
            $registration_data = $request->all();
            $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();

            // Almacenar los datos de registro en la sesión
            $request->session()->put('registration_data', $registration_data);

            // Generar el código QR para la autenticación de dos factores
            $QR_Image = $google2fa->getQRCodeInline(
                config('app.name'),
                $registration_data['email'],
                $registration_data['google2fa_secret']
            );

            // Mostrar la vista de registro de Google 2FA con el código QR
            return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
        }
    }

    /**
     * Complete the registration process using the data stored in the session.
     *
     * This method merges the data stored in the session with the current request and
     * calls the registration method to finalize the process.
     *
     * @return \Illuminate\Http\Response
     */
    public function completeRegistration(Request $request)
    {
        // Fusionar los datos almacenados en la sesión con la solicitud actual
        $request->merge(session('registration_data'));

        // Llamar al método de registro para finalizar el proceso
        return $this->registration($request);
    }
}
