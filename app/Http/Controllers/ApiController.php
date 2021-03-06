<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/01/16
 * Time: 0:45
 */

namespace App\Http\Controllers;



use Illuminate\Http\Response as IluminateResponse;
use Response;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = IluminateResponse::HTTP_NOT_FOUND;

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
        return $this->setStatusCode(IluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal error')
    {
        return $this->setStatusCode(IluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
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

    public function respondCreated($message)
    {
        return $this->setStatusCode(IluminateResponse::HTTP_CREATED)->respond([

            'message' => $message
        ]);
    }
}