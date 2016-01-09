<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/01/16
 * Time: 0:45
 */

namespace App\Http\Controllers;


use Response;

class ApiController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 404;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([

            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]

        ]);
    }
}