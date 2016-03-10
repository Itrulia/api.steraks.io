<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Whoops\Run;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        UnauthorizedException::class,
        UnauthenticatedException::class,
        TokenExpiredException::class,
        TokenInvalidException::class,
    ];

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        $client = app()->make('Maknz\Slack\Client');

        if (app()->environment() === 'production') {
            $client = $client->to('#exceptions');
        } else {
            $client = $client->to('#test');
        }

        $client->attach([
            'text' =>  $e->getMessage(),
            'color' => 'danger',
            ])->send(get_class($e) . ' @ ' .  $e->getFile() . ':' . $e->getLine());

        parent::report($e);
    }

    /**
     * Render an exception using Whoops.
     *
     * @param  \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return response($whoops->handleException($e));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $headers = [
            'Access-Control-Allow-Origin'   => '*',
            'Access-Control-Allow-Methods'  => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'  => 'Content-Type, X-Auth-Token, Origin',
            'Access-Control-Expose-Headers' => 'X-Auth-Token'
        ];

        if ($e instanceof TokenExpiredException) {
            return response()->json([
                'message' => 'The train was late, eh?',
                'error' => 'token_expired',
                'statuscode' => $e->getStatusCode()
            ], $e->getStatusCode(), $headers);
        }

        if ($e instanceof TokenInvalidException) {
            return response()->json([
                'message' => 'I think that isn\'t going to work out.',
                'error' => 'token_invalid',
                'statuscode' => $e->getStatusCode()
            ], $e->getStatusCode(), $headers);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'He is dead Jim, the link is dead!',
                'error' => 'not_found',
                'statuscode' => 404
            ], 404, $headers);
        }

        if ($e instanceof UnauthenticatedException) {
            return response()->json([
                'message' => 'You shall not pass!',
                'error' => 'logged_out',
                'statuscode' => 401
            ], 401, $headers);
        }

        if ($e instanceof UnauthorizedException) {
            return response()->json([
                'message' => 'Computer says no.',
                'error' => 'no_permission',
                'statuscode' => 403
            ], 403, $headers);
        }

        if ($e instanceof NotImplementedException) {
            return response()->json([
                'message' => 'Too cutting edge.',
                'error' => 'not_implemented',
                'statuscode' => 403
            ], 403, $headers);
        }

        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e, $headers);
        }

        if (config('app.debug') && !request()->ajax()) {
            return $this->renderExceptionWithWhoops($e);
        }

        return response()->json([
            'message' => 'Have you tried to turn it off and on again?',
            'error' => 'internal_error'
        ], 500, $headers);
    }
}
