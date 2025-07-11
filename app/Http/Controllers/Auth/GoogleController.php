<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * @group Autenticación
 *
 * APIs para autenticación con Google
 */
class GoogleController extends Controller
{
    /**
     * Redirección a Google
     *
     * Redirige al usuario a la página de inicio de sesión de Google.
     *
     * @response 302 {}
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback de Google
     *
     * Maneja la respuesta después de la autenticación con Google.
     * Crea o actualiza el usuario y lo autentica en la aplicación.
     *
     * @response 302 {}
     *
     * @response status=500 scenario="Error en la autenticación" {
     *   "message": "Error al procesar la autenticación con Google",
     *   "errors": {
     *     "google": ["No se pudo obtener la información del usuario de Google"]
     *   }
     * }
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->getId(),
        ], [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        Auth::login($user);

        return redirect('/home');
    }
}
