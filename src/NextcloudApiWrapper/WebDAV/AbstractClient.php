<?php

namespace NextcloudApiWrapper\WebDAV;


use DOMDocument;

abstract class AbstractClient extends \NextcloudApiWrapper\AbstractClient
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @param SimpleXMLElement $simpleXMLElement
     * @return string
     */
    function formatXml($simpleXMLElement)
    {
        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($simpleXMLElement->asXML());
        return $xmlDocument->saveXML();
    }
}