<?php namespace professionalweb\IntegrationHub\IntegrationHub\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function render($request, Exception $e): ?Response
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

        return null;
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
