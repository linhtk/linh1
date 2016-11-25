<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use  \Illuminate\Session\TokenMismatchException as TokenMismatchException;
use RuntimeException as RuntimeException;
use Predis\Connection\ConnectionException as ConnectionException ;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
       //Thanhdv 2016-10-18 check exeption
       switch(true) {
            case $exception instanceof NotFoundHttpException:
                return redirect('/');
                //return response()->view('errors.404', [], 404);
                break;
            case $exception instanceof TokenMismatchException:
                session()->flash('error_session_expired', trans('account.handler_error_login_session'));
                return redirect()->back()->with('token', csrf_token());
                break;
            case $exception instanceof RuntimeException:
            case $exception instanceof ConnectionException:
                return redirect('error/error')->withErrors(['message_error' => trans('account.err_exeption_system')]);
                break;
            default:
                break;
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
