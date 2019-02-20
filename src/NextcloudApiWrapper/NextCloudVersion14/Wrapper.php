<?php

namespace NextcloudApiWrapper\NextCloudVersion14;

use \NextcloudApiWrapper\Connection;

class Wrapper extends \NextcloudApiWrapper\Wrapper
{

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @return UsersClient
     */
    public function getUsersClient() {

        return $this->getClient(UsersClient::class);
    }
}
