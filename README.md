<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Vakano P2P - Plataforma con Autenticación de Google

Este proyecto incluye autenticación de usuarios mediante Google OAuth usando Laravel Socialite en Laravel 12.

## Tabla de contenidos

- [Requisitos previos](#requisitos-previos)
- [Instalación](#instalación)
- [Configuración de autenticación con Google](#configuración-de-autenticación-con-google)
  - [Obtener credenciales de Google](#obtener-credenciales-de-google)
  - [Configurar variables de entorno](#configurar-variables-de-entorno)
- [Cómo funciona la autenticación](#cómo-funciona-la-autenticación)
- [Estructura del código](#estructura-del-código)

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Cuenta de Google para acceder a Google Cloud Console
- Base de datos compatible con Laravel (MySQL, PostgreSQL, SQLite)

## Instalación

1. Clona el repositorio
   ```bash
   git clone <repositorio>
   cd p2p
   ```

2. Instala las dependencias
   ```bash
   composer install
   ```

3. Copia el archivo de entorno y genera la clave de la aplicación
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configura la base de datos en el archivo `.env`

5. Ejecuta las migraciones
   ```bash
   php artisan migrate
   ```

## Configuración de autenticación con Google

### Obtener credenciales de Google

1. Accede a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto o selecciona uno existente
3. Navega a **APIs y servicios** > **Pantalla de consentimiento de OAuth**
   - Configura la pantalla de consentimiento (tipo Externo o Interno)
   - Completa la información requerida (nombre de la aplicación, correo de soporte, etc.)

4. Ve a **APIs y servicios** > **Credenciales**
   - Haz clic en **Crear credenciales** > **ID de cliente de OAuth**
   - Selecciona **Aplicación web**
   - Asigna un nombre a tu cliente
   - En **Orígenes de JavaScript autorizados**, añade tu URL base (ej: `http://localhost:8000`)
   - En **URIs de redirección autorizados**, añade la URL de callback:
     ```
     http://localhost:8000/auth/google/callback
     ```
   - Haz clic en **Crear**

5. Guarda el **ID de cliente** y **Secreto del cliente** generados

### Configurar variables de entorno

1. Abre el archivo `.env` y añade las siguientes variables:
   ```
   GOOGLE_CLIENT_ID=tu_client_id_aquí
   GOOGLE_CLIENT_SECRET=tu_client_secret_aquí
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

2. Asegúrate de que la URL de redirección coincida exactamente con la configurada en Google Cloud Console

## Cómo funciona la autenticación

1. El usuario hace clic en el botón "Iniciar sesión con Google"
2. El usuario es redirigido a la página de inicio de sesión de Google
3. Después de autenticarse, Google redirige al usuario de vuelta a la aplicación
4. La aplicación crea o actualiza el registro del usuario con la información de Google
5. El usuario inicia sesión automáticamente y es redirigido a la página principal

## Estructura del código

- **Rutas**: Las rutas de autenticación se definen en `routes/web.php`
  ```php
  Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
  Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
  ```

- **Controlador**: La lógica de autenticación está en `app/Http/Controllers/Auth/GoogleController.php`
  ```php
  // Redirección a Google
  public function redirectToGoogle()
  {
      return Socialite::driver('google')->redirect();
  }

  // Manejo de la respuesta
  public function handleGoogleCallback()
  {
      $googleUser = Socialite::driver('google')->stateless()->user();
      // Crear/actualizar usuario y iniciar sesión
  }
  ```

- **Configuración**: La configuración de Google se define en `config/services.php`
  ```php
  'google' => [
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect' => env('GOOGLE_REDIRECT_URI'),
  ],
  ```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
