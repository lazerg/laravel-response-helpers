<?php

namespace lazerg\LaravelResponseHelpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Response;

trait ResponseHelpers
{
    /**
     * Generate a structure for response
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function response(string $message, $data = [], int $statusCode = 200): JsonResponse
    {
        return Response::json([
            'message' => $message,
            'data'    => $data,
        ])
            ->setStatusCode($statusCode);
    }

    /**
     * Response with data only
     *
     * @param mixed $data
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function responseData($data, int $statusCode = 200): JsonResponse
    {
        return $this->response('', $data, $statusCode);
    }

    /**
     * Response with message only
     *
     * @param string $message
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function responseMessage(string $message, int $statusCode = 200): JsonResponse
    {
        return $this->response($message, [], $statusCode);
    }

    /**
     * Response resourcefully
     *
     * @param string $class
     * @param Collection|Model $data
     * @param int $status
     * @return JsonResponse
     */
    protected function responseResourceful(string $class, $data, int $status = 200): JsonResponse
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            return (call_user_func_array([$class, 'collection'], [$data]))
                ->response()
                ->setStatusCode($status);
        }

        if ($data instanceof \Illuminate\Database\Eloquent\Model) {
            return (new $class($data))
                ->response()
                ->setStatusCode($status);
        }
    }
}
