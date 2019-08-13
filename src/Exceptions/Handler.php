<?php namespace professionalweb\IntegrationHub\IntegrationHub\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     * @throws \InvalidArgumentException
     */
    public function render($request, Exception $e)
    {
        if ($request->is('api/*')) {
            $code = 500;
            if ($e instanceof HttpException) {
                $code = $e->getStatusCode();
                $data = [$this->createError($e, $code)];
            } else {
                $data = [$this->createError(new HttpException($code, 'Unexpected error'), $code)];
            }

            return response()->json($data)->setStatusCode($code);
        }

        return parent::render($request, $e);
    }

    /**
     * Create error object
     *
     * @param Exception $exception
     *
     * @param int       $code
     *
     * @return array
     */
    protected function createError(Exception $exception, int $code = 0): array
    {
        $result = [
            'code'  => $code,
            'error' => $exception->getMessage(),
        ];

        \Log::info($exception);
        \Log::info($result);

        return $result;
    }
}
