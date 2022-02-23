<?php

namespace Lazerg\LaravelResponseHelpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
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
    protected function response(?string $message = '', $data = [], int $statusCode = 200): JsonResponse
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
     * @param string $class
     * @param Collection|AbstractPaginator|Model $data
     * @param string|null $message
     * @param int $statusCode
     *
     * @return JsonResponse
     */
    protected function responseJsonResourceful(string $class, $data, ?string $message = null, int $statusCode = 200): JsonResponse
    {
        if ($data instanceof Model) {
            /** @var JsonResource $data */
            $data = new $class($data);

            $data = $data->response()->getData()->data;
        }

        if ($data instanceof AbstractPaginator) {
            /** @var AnonymousResourceCollection $data */
            $data = call_user_func_array([$class, 'collection'], [$data]);

            $data = $data->response()->getData();
        }

        if ($data instanceof Collection) {
            /** @var AnonymousResourceCollection $data */
            $data = call_user_func_array([$class, 'collection'], [$data]);

            $data = $data->response()->getData()->data;
        }

        return $this->response($message, $data, $statusCode);
    }

    protected function responseResourceful(string $class, $data, int $status = 200): JsonResponse
    {
        return $this->responseJsonResourceful($class, $data, null, $status);
    }
}
