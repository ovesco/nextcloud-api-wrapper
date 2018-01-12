<?php

namespace NextcloudApiWrapper;

use GuzzleHttp\Psr7\Response;

class NCException extends \Exception
{
    /**
     * @var Response
     */
    protected $response;

    public function __construct(Response $response, $message = "", $code = 0, \Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}