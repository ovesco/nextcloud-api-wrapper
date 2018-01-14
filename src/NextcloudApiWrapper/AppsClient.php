<?php

namespace NextcloudApiWrapper;

class AppsClient extends AbstractClient
{
    const APP_PART  = 'v1.php/cloud/apps';

    /**
     * Gets a list of apps
     * @param null $filter can be either 'enabled' or 'disabled' to filter apps
     * @return NextcloudResponse
     */
    public function getApps($filter = null) {

        return $this->connection->request(Connection::GET, self::APP_PART . $this->connection->buildUriParams([
                'filter'    => $filter
            ]));
    }

    /**
     * Returns infos for an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function getAppInfo($appname) {

        return $this->connection->request(Connection::GET, self::APP_PART . '/' . $appname);
    }

    /**
     * Enables an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function enableApp($appname) {

        return $this->connection->request(Connection::POST, self::APP_PART . '/' . $appname);
    }

    /**
     * Disables an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function disableApp($appname) {

        return $this->connection->request(Connection::DELETE, self::APP_PART . '/' . $appname);
    }

}