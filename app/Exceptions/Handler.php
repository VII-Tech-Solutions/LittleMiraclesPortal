<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpFoundation\Response;
use VIITech\Helpers\Packagist\SentryHelper;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Exception $exception)
    {

        // Kill reporting if this is an "access denied" (code 9) OAuthServerException.
        if ($exception instanceof OAuthServerException && $exception->getCode() == 9) {
            return;
        }

        SentryHelper::capture($this, $exception);

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return Response
     *
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
