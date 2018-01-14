<?php

namespace NextcloudApiWrapper;

class Wrapper
{
    /**
     * @var Connection
     */
    protected $connection;

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

        return new AppsClient($this->connection);
    }

    /**
     * @return FederatedCloudSharesClient
     */
    public function getFederatedCloudSharesClient() {

        return new FederatedCloudSharesClient($this->connection);
    }

    /**
     * @return GroupsClient
     */
    public function getGroupsClient() {

        return new GroupsClient($this->connection);
    }

    /**
     * @return SharesClient
     */
    public function getSharesClient() {

        return new SharesClient($this->connection);
    }

    /**
     * @return UsersClient
     */
    public function getUsersClient() {

        return new UsersClient($this->connection);
    }
}