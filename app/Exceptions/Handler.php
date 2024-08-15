<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Exception $e, $request) {
            if ($request->is('api/*')) {
                $exceptionClass = get_class($e);

                $customExceptionClass = match ($exceptionClass) {
                    \Illuminate\Auth\AuthenticationException::class => \App\Exceptions\Auth\UnauthenticatedException::class,
                    \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => \App\Exceptions\NotFoundException::class,
                    \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException::class => \App\Exceptions\UnauthorizedActionException::class,
                    default => null
                };

                throw_if($customExceptionClass, $customExceptionClass);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
