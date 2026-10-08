<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'payment/callback',
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'instructor' => \App\Http\Middleware\EnsureUserIsInstructor::class,
            'user' => \App\Http\Middleware\EnsureUserIsUser::class,
            'jwt.auth' => \App\Http\Middleware\JWTAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $e, $request) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ukuran file terlalu besar. Maksimal ukuran file tugas adalah 10MB.');
        });

        $handle419 = function ($request) {
            $url = $request->url();

            if (str_contains($url, '/admin/login')) {
                return redirect()->route('admin.login')
                    ->with('warning', 'Halaman expired, silakan coba lagi.');
            }

            if (str_contains($url, '/instructor/login')) {
                return redirect()->route('instructor.login')
                    ->with('warning', 'Halaman expired, silakan coba lagi.');
            }

            if (str_contains($url, '/login')) {
                return redirect()->route('login')
                    ->with('warning', 'Halaman expired, silakan coba lagi.');
            }

            return redirect()->back()
                ->with('error', 'Sesi telah berakhir, silakan refresh halaman.');
        };

        $exceptions->render(function (TokenMismatchException $e, $request) use ($handle419) {
            return $handle419($request);
        });

        $exceptions->render(function (HttpException $e, $request) use ($handle419) {
            if ($e->getStatusCode() === 419) {
                return $handle419($request);
            }
            return null;
        });
    })->create();
