<?php

namespace NextcloudApiWrapper\NextCloudVersion14;

use \NextcloudApiWrapper\Connection;
use \NextcloudApiWrapper\NextcloudResponse;

class UsersClient extends \NextcloudApiWrapper\UsersClient
{

    /**
     * Adds a user.
     * @param $username
     * @param $password
     * @param string $displayName
     * @param string $email
     * @param array $groups
     * @param array $subadmin
     * @param string $quota
     * @param string $language
     * @return NextcloudResponse
     */
    public function addUser($username,
                            $password,
                            $displayName = '',
                            $email = '',
                            $groups = [],
                            $subadmin = [],
                            $quota = '',
                            $language = '')
    {

        return $this->connection->submitRequest(Connection::POST, self::USER_PART, [
            'userid' => $username,
            'password' => $password,
            'displayName' => $displayName,
            'email' => $email,
            'groups' => $groups,
            'subadmin' => $subadmin,
            'quota' => $quota,
            'language' => $language
        ]);
    }
}
