<?php

namespace NextcloudApiWrapper;

use GuzzleHttp\Psr7\Response;

class NextcloudResponse
{
    /**
     * @var Response
     */
    protected $guzzle;

    /**
     * @var \SimpleXMLElement
     */
    protected $body;

    public function __construct(Response $guzzle)
    {
        $this->guzzle   = $guzzle;

        try {
            $this->body = new \SimpleXMLElement($guzzle->getBody()->getContents());
        } catch (\Exception $e) {
            throw new NCException($guzzle, "Failed parsing response");
        }
    }

    /**
     * Returns nextcloud status message
     * @return string
     */
    public function getStatus() {

        return (string)$this->body->meta->status;
    }

    /**
     * Returns nextcloud status code
     * @return int
     */
    public function getStatusCode() {

        return intval($this->body->meta->statuscode);
    }

    /**
     * Returns nextcloud response data if any
     * @return array|null
     */
    public function getData() {

        $data   = $this->body->data;
        return empty((string)$data) ? null : $this->xml2array($data);
    }

    /**
     * Returns the raw guzzle response
     * @return Response
     */
    public function getRawResponse() {

        return $this->guzzle;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param array $out
     * @return array
     */
    protected function xml2array(\SimpleXMLElement $xml, $out = []) {

        foreach( (array)$xml as $index => $node)
            $out[$index] = $node instanceof \SimpleXMLElement ? $this->xml2array($node) : $node;

        return $out;
    }
}