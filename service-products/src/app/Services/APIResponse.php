<?php

namespace App\Services;

use Illuminate\Http\Response;

/**
 * Class APIResponse
 * @package App
 */
class APIResponse
{
    /**
     * @var integer $statusCode | HTTP status code
     */
    private int $statusCode = 200;

    /**
     * @var array|object  $data | Data to be sent in the 'data' field
     */
    private $data;

    /**
     * @var string $message | Message included in the request
     */
    private string $message;


    /**
     * Return Error Response
     *
     * @param int $code
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public static function errorResponse(int $code, string $message = '')
    {
        return self::sendResponse($code, [], $message);
    }

    /**
     * Return response
     *
     * @param int $code
     * @param array|object $data
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public static function sendResponse(int $code, $data, string $message = '')
    {
        return (new APIResponse)
            ->setCode($code)
            ->setMessage($message)
            ->setData($data)
            ->send();
    }

    /**
     * Build the response body
     *
     * @return array
     */
    private function builder()
    {
        return [
            'data' => $this->data,
            'message' => $this->message
        ];
    }

    /**
     * Send the Response
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    private function send()
    {
        return response(self::builder(), $this->statusCode)->header('Content-Type', 'text/json');
    }


    /**
     * Set the HTTP Response code
     *
     * @param int $value
     * @return $this
     */
    private function setCode(int $value)
    {
        $this->statusCode = $value;

        return $this;
    }

    /**
     * Set the response data
     *
     * @param array|object $value
     * @return $this
     */
    private function setData($value)
    {
        $this->data = $value;

        return $this;
    }

    /**
     * Set the message field
     *
     * @param string $value
     * @return $this
     */
    private function setMessage(string $value)
    {
        $this->message = $value;

        return $this;
    }
}
