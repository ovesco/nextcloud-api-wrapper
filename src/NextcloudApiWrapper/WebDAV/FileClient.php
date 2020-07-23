<?php


namespace NextcloudApiWrapper\WebDAV;

use NextcloudApiWrapper\NextcloudResponse;
use SimpleXMLElement;

class FileClient extends AbstractClient
{
    const FILE_PART  = 'files';

    /**
     * @param $pathToFolder
     * @param array $params
     * @return NextcloudResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function listFolder($pathToFolder, array $params = [], $resursive = true) {
        if (empty($params)) {
            return $this->connection->request(Connection::PROFIND, self::FILE_PART . '/'  . $pathToFolder);
        }
        $xml = new SimpleXMLElement('<?xml version="1.0"?>
            <d:propfind  ' . XMLTypesEnum::XML_TYPE_ALIASES . '>
            </d:propfind>');

        $xmlProp = $xml->addChild("d:prop");
        foreach ($params as $param) {
            if (key_exists($param, XMLTypesEnum::FOLDER_PARAMS_TO_XML_TYPE)) {
                $xmlProp->addChild(XMLTypesEnum::FOLDER_PARAMS_TO_XML_TYPE[$param]);
            }
        }

        $header = $resursive === false ? ["Depth" => 0] : [];

        return $this->connection->xmlRequest(Connection::PROFIND, self::FILE_PART . '/'  . $pathToFolder, $xml->asXML(), $header);
    }

    /**
     * @param $pathToFile
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadFile($pathToFile) {
        return $this->connection->rawRequest(Connection::GET, $pathToFile);
    }

    /**
     * @param $pathToFile
     * @param $fileContent
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function uploadFile($pathToFile, $fileContent) {
        $this->connection->noBodyRequest(Connection::PUT, $pathToFile, null, $fileContent);
    }

    /**
     * @param $pathToFolder
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function createFolder($pathToFolder) {

        $this->connection->noBodyRequest(Connection::MKCOL, self::FILE_PART . '/'  . $pathToFolder);
    }

    /**
     * @param $pathToFolder
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function deleteFolder($pathToFolder) {

        $this->connection->noBodyRequest(Connection::DELETE, self::FILE_PART . '/'  . $pathToFolder);
    }

    /**
     * @param $sourcePath
     * @param $destinationPath
     * @param null $name - use when you do not want to rename file or folder
     *                  - when not null it append after sourcePath and also destinationPath
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function move($sourcePath, $destinationPath, $name = null) {

        if ($name !== null) {
            $sourcePath .= "/" . $name;
            $destinationPath .= "/" . $name;
        }
        $this->connection->noBodyRequest(Connection::MOVE, self::FILE_PART . '/'  . $sourcePath, null, null, ["Destination" => $destinationPath]);
    }

    /**
     * @param $sourcePath
     * @param $destinationPath
     * @param null $name - use when you do not want to rename file or folder
     *                  - when not null it append after sourcePath and also destinationPath
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function copy($sourcePath, $destinationPath, $name = null) {

        if ($name !== null) {
            $sourcePath .= "/" . $name;
            $destinationPath .= "/" . $name;
        }
        $this->connection->noBodyRequest(Connection::COPY, self::FILE_PART . '/'  . $sourcePath, null, null, ["Destination" => $destinationPath]);
    }

    /**
     * @param $path
     * @param array $params
     * @return NextcloudResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function favourite($path, $params = []) {
        $xml = new SimpleXMLElement('<?xml version="1.0"?>
            <d:propertyupdate  ' . XMLTypesEnum::XML_TYPE_ALIASES . '>
            </d:propertyupdate>');

        $xmlProp = $xml->addChild("d:set")->addChild("d:prop");
        foreach ($params as $key=>$value) {
            if (key_exists($key, XMLTypesEnum::FAVOURITE_PARAMS_TO_XML_TYPE)) {
                if (is_bool($value)) {
                    $value = $value ? 1 : 0;
                }
                $xmlProp->addChild(XMLTypesEnum::FAVOURITE_PARAMS_TO_XML_TYPE[$key], $value);
            }
        }

        return $this->connection->xmlRequest(Connection::PROFIND, self::FILE_PART . '/'  . $path, $xml->asXML());
    }

    /**
     * @param $path
     * @param array $params
     * @return NextcloudResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \NextcloudApiWrapper\NCException
     */
    public function filter($path, $params = []) {
        $xml = new SimpleXMLElement('<?xml version="1.0"?>
            <oc:filter-files  ' . XMLTypesEnum::XML_TYPE_ALIASES . '>
            </oc:filter-files>');

        $xmlFilterRules = $xml->addChild("oc:filter-rules");
        foreach ($params as $key=>$value) {
            if (key_exists($key, XMLTypesEnum::FAVOURITE_PARAMS_TO_XML_TYPE)) {
                if (is_bool($value)) {
                    $value = $value ? 1 : 0;
                }
                $xmlFilterRules->addChild(XMLTypesEnum::FAVOURITE_PARAMS_TO_XML_TYPE[$key], $value);
            } else if (key_exists($key, XMLTypesEnum::FOLDER_PARAMS_TO_XML_TYPE)) {
                if (is_bool($value)) {
                    $value = $value ? 1 : 0;
                }
                $xmlFilterRules->addChild(XMLTypesEnum::FOLDER_PARAMS_TO_XML_TYPE[$key], $value);
            }
        }

        return $this->connection->xmlRequest(Connection::PROFIND, self::FILE_PART . '/'  . $path, $xml->asXML());
    }

}