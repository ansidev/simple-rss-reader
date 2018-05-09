<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            return $this->buildJsonResponse($exception);
        }
        return parent::render($request, $exception);
    }

    private function buildJsonResponse($exception)
    {
        $message = "Internal Server Error";
        $statusCode = 500;

        if ($exception instanceof ModelNotFoundException) {
            $message = $exception->getMessage();
            $statusCode = 404;
        }

        if ($exception instanceof BadRequestHttpException) {
            $message = $exception->getMessage();
            $statusCode = 400;
        }

        return response()->json([
            'data' => $message
        ], $statusCode);
    }
}
