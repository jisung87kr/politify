<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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
        Response::macro('success', function ($data, $message = 'success') {
            return Response::json([
                'status' => 'success',
                'message' => $message,
                'data' => $data,
            ]);
        });

        Response::macro('error', function ($message = 'error', $code = 400) {
            return Response::json([
                'status' => 'error',
                'message' => $message,
            ], $code);
        });
    }
}
