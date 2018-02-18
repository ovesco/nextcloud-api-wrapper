<?php

namespace NextcloudApiWrapper;

class Wrapper
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var AbstractClient
     */
    protected $clients  = [];

    private function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public static function build($baseUri, $username, $password) {

        $connection = new Connection($baseUri, $username, $password);
        return new Wrapper($connection);
    }

    /**
     * @return Connection
     */
    public function getConnection() {

        return $this->connection;
    }

    /**
     * @return AppsClient
     */
    public function getAppsClient() {

        return $this->getClient(AppsClient::class);
    }

    /**
     * @return FederatedCloudSharesClient
     */
    public function getFederatedCloudSharesClient() {

        return $this->getClient(FederatedCloudSharesClient::class);
    }

    /**
     * @return GroupsClient
     */
    public function getGroupsClient() {

        return $this->getClient(GroupsClient::class);
    }

    /**
     * @return SharesClient
     */
    public function getSharesClient() {

        return $this->getClient(SharesClient::class);
    }

    /**
     * @return UsersClient
     */
    public function getUsersClient() {

        return $this->getClient(UsersClient::class);
    }

    /**
     * @param $class
     * @return mixed
     */
    protected function getClient($class) {

        if(!isset($this->clients[$class]))
            $this->clients[$class] = new $class($this->connection);

        return $this->clients[$class];
    }
}