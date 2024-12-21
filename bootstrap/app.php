<?php

use App\Http\Middleware\Authenticate as AuthenticateMiddleware;
use App\Http\Middleware\BackstageAbility as BackstageAbilityMiddleware;
use Handyfit\Framework\Foundation\Http\Middleware\PreacherResponse as PreacherResponseMiddleware;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))->withRouting(
    using: function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::prefix('dev-ops')
            ->name('dev-ops.')
            ->middleware(['web', PreacherResponseMiddleware::class])
            ->group(base_path('routes/dev-ops.php'));
    },
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
)->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'backstage.ability' => BackstageAbilityMiddleware::class,
        'auth' => AuthenticateMiddleware::class,
    ]);

    $middleware->web([
        StartSession::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
    ]);

    $middleware->validateCsrfTokens(except: [
        'dev-ops/*',
    ]);
})->withExceptions(function (Exceptions $exceptions) {

    $exceptions->render(function (MethodNotAllowedHttpException $e) {
        return Preacher::msgCode(
            $e->getStatusCode(),
            'Method Not Allowed'
        )->export()->json();
    });

    $exceptions->render(function (NotFoundHttpException $e) {
        return Preacher::msgCode(
            $e->getStatusCode(),
            $e->getStatusCode() . ' Not Found'
        )->export()->json();
    });

    $exceptions->render(function (ValidationException $e) {
        return Preacher::msgCode(
            PreacherResponse::RESP_CODE_WARN,
            $e->getMessage()
        )->export()->json();
    });

    $exceptions->render(function (Exception $e) {
        return Preacher::msgCode(
            PreacherResponse::RESP_CODE_WARN,
            $e->getMessage()
        )->export()->json();
    });

})->create();
