<?php

namespace NextcloudApiWrapper;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;

class Connection
{
    const GET           = 'GET';
    const POST          = 'POST';
    const PUT           = 'PUT';
    const DELETE        = 'DELETE';

    /**
     * @var Client
     */
    protected $guzzle;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $basePath  The base path to nextcloud api, IE. 'http://nextcloud.mydomain.com/ocs/'
     * @param string $username  The username of the user performing api calls
     * @param string $password  The password of the user performing api calls
     */
    public function __construct($basePath, $username, $password)
    {
        $this->guzzle   = new Client(['base_uri' => $basePath]);
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Performs a simple request
     * @param $verb
     * @param $path
     * @param null $params
     * @return NextcloudResponse
     */
    public function request($verb, $path, $params = null) {

        $params     = $params === null ? $this->getBaseRequestParams() : $params;
        $response   = $this->guzzle->request($verb, $path, $params);

        return new NextcloudResponse($response);
    }

    /**
     * Performs a request adding the application/x-www-form-urlencoded header
     * @param $verb
     * @param $path
     * @param array $params
     * @return NextcloudResponse
     */
    public function pushDataRequest($verb, $path, array $params = []) {

        $params = empty($params) ? $this->getBaseRequestParams() : $params;
        $params['headers']['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this->request($verb, $path, $params);
    }

    /**
     * Performs a request sending form data.
     * Required header automatically added by CURl
     * @param $verb
     * @param $path
     * @param array $formParams
     * @return NextcloudResponse
     */
    public function submitRequest($verb, $path, array $formParams) {

        return $this->request($verb, $path, array_merge($this->getBaseRequestParams(), [
            RequestOptions::FORM_PARAMS => $formParams
        ]));
    }

    /**
     * Returns the base request parameters required by nextcloud to
     * answer api calls
     * @return array
     */
    protected function getBaseRequestParams() {

        return [
            RequestOptions::HEADERS => [
                'OCS-APIRequest'    => 'true'
            ],

            RequestOptions::AUTH    => [
                $this->username,
                $this->password,
                'basic'
            ]
        ];
    }
}