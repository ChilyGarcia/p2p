<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Illuminate\Http\Resources\Json\JsonResource;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        // Define rutas para la documentación de la API
        Scramble::routes(function () {
            // Incluye todas las rutas que comienzan con 'api'
            return collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
                ->filter(function (\Illuminate\Routing\Route $route) {
                    return str_starts_with($route->uri(), 'api');
                });
        });
    }
}
