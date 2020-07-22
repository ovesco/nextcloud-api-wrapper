<?php


namespace NextcloudApiWrapper\WebDAV;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use NextcloudApiWrapper\NCException;
use NextcloudApiWrapper\NextcloudResponse;
use Psr\Http\Message\ResponseInterface;

class Connection extends \NextcloudApiWrapper\Connection
{

    const URL_SUFIX = "remote.php/dav";

    const PROFIND = "PROFIND";
    const PROPPATH = "PROPPATH";
    const REPORT = "REPORT";

    const MKCOL = "MKCOL";
    const MOVE = "MOVE";
    const COPY = "COPY";

    /**
     * @param string $basePath  The base path to nextcloud api, IE. 'http://nextcloud.mydomain.com'
     * @param string $username  The username of the user performing api calls
     * @param string $password  The password of the user performing api calls
     */
    public function __construct($basePath, $username, $password)
    {
        parent::__construct($basePath . "/" . self::URL_SUFIX . "/", $username, $password);
    }

    /**
     * @param $method
     * @param $uri
     * @param $xml
     * @param array $header
     * @return NextcloudResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function xmlRequest($method, $uri, $xml, $headers = []) {

        return $this->request($method, $uri, null, $xml, $headers);
    }

    /**
     * @param $method
     * @param $uri
     * @param null $params
     * @param null $data
     * @param array $headers
     * @return bool
     * @throws NCException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function noBodyRequest($method, $uri, $params = null, $data = null, $headers = []) {

        $response = $this->rawRequest($method, $uri, $params, $data, $headers);
        switch ($response->getStatusCode()) {
            default:
                throw new NCException($response);
            case 201:
            case 202:
            case 204:
                return true;
        }
    }

    /**
     * @param $method
     * @param $uri
     * @param null $params
     * @param null $data
     * @param array $headers
     * @return NextcloudResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function request($method, $uri, $params = null, $data = null, $headers = []) {

        $response = $this->rawRequest($method, $uri, $params, $data, $headers);

        return new NextcloudResponse($response);
    }

    /**
     * @param $method
     * @param $uri
     * @param null $params
     * @param null $data
     * @param array $headers
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function rawRequest($method, $uri, $params = null, $data = null, $headers = []) {

        $params     = $params === null ? $this->getBaseRequestParams() : $params;
        $request = new Request($method, $uri, $headers, $data);
        return $this->guzzle->send($request, $params);
    }
}