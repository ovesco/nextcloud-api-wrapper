<?php

namespace NextcloudApiWrapper;

class Wrapper
{
    const GET           = 'GET';
    const POST          = 'POST';
    const PUT           = 'PUT';
    const DELETE        = 'DELETE';

    const USER_PART     = 'cloud/users';
    const APP_PART      = 'cloud/apps';
    const GROUP_PART    = 'cloud/groups';

    /**
     * @var NextcloudClient
     */
    protected $client;

    public function __construct($basePath, $username, $password) {

        $this->client = new NextcloudClient($basePath, $username, $password);
    }

    /**
     * Adds a user.
     * @param $username
     * @param $password
     * @return NextcloudResponse
     */
    public function addUser($username, $password) {

        return $this->client->submitRequest(self::POST, self::USER_PART, [
            'userid'    => $username,
            'password'  => $password
        ]);
    }

    /**
     * Gets a list of users.
     * @param array $params
     * @return NextcloudResponse
     */
    public function getUsers(array $params = []) {

        return $this->client->request(self::GET, self::USER_PART . $this->client->buildUriParams($params));
    }

    /**
     * Gets data about a given user
     * @param $username
     * @return NextcloudResponse
     */
    public function getUser($username) {

        return $this->client->request(self::GET, self::USER_PART . '/' . $username);
    }

    /**
     * Updates a user, sets the value identified by key to value
     * @param $username
     * @param $key
     * @param $value
     * @return NextcloudResponse
     */
    public function updateUser($username, $key, $value) {

        return $this->client->submitRequest(self::PUT, self::USER_PART . '/' . $username, [
            'key'   => $key,
            'value' => $value
        ]);
    }

    /**
     * Disables a user
     * @param $username
     * @return NextcloudResponse
     */
    public function disableUser($username) {

        return $this->client->pushDataRequest(self::PUT, self::USER_PART . '/' . $username . '/disable');
    }

    /**
     * Enables a user
     * @param $username
     * @return NextcloudResponse
     */
    public function enableUser($username) {

        return $this->client->pushDataRequest(self::PUT, self::USER_PART . '/' . $username . '/enable');
    }

    /**
     * Deletes a user
     * @param $username
     * @return NextcloudResponse
     */
    public function deleteUser($username) {

        return $this->client->request(self::DELETE, self::USER_PART . '/' . $username);
    }

    /**
     * Returns user's groups
     * @param $username
     * @return NextcloudResponse
     */
    public function getUserGroups($username) {

        return $this->client->request(self::GET, self::USER_PART . '/' . $username . '/groups');
    }

    /**
     * Adds a user to a group
     * @param $username
     * @param $groupname
     * @return NextcloudResponse
     */
    public function addUserToGroup($username, $groupname) {

        return $this->client->submitRequest(self::POST, self::USER_PART . '/' . $username . '/groups', [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Removes a user from a group
     * @param $username
     * @param $groupname
     * @return NextcloudResponse
     */
    public function removeUserFromGroup($username, $groupname) {

        return $this->client->submitRequest(self::DELETE, self::USER_PART . '/' . $username . '/groups', [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Makes a user a subadmin of a group
     * @param $username
     * @param $groupname
     * @return NextcloudResponse
     */
    public function promoteUserSubadminOfGroup($username, $groupname) {

        return $this->client->submitRequest(self::POST, self::USER_PART . '/' . $username . '/subadmins', [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Demotes a user subadmin group
     * @param $username
     * @param $groupname
     * @return NextcloudResponse
     */
    public function demoteUserSubadminOfGroup($username, $groupname) {

        return $this->client->submitRequest(self::DELETE, self::USER_PART . '/' . $username . '/subadmins', [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Returns all groups in which this user is subadmin
     * @param $username
     * @return NextcloudResponse
     */
    public function getUserSubadminGroups($username) {

        return $this->client->request(self::GET, self::USER_PART . '/' . $username . '/subadmins');
    }

    /**
     * Resend the welcome mail
     * @param $username
     * @return NextcloudResponse
     */
    public function resendWelcomeEmail($username) {

        return $this->client->request(self::POST, self::USER_PART . '/' . $username . '/welcome');
    }

    /**
     * Search for groups
     * @param $search
     * @return NextcloudResponse
     */
    public function searchGroups($search = '') {

        return $this->client->request(self::GET, self::GROUP_PART . $this->client->buildUriParams([
                'search'    => $search
            ]));
    }

    /**
     * Creates a new group
     * @param $groupname
     * @return NextcloudResponse
     */
    public function addGroup($groupname) {

        return $this->client->submitRequest(self::POST, self::GROUP_PART, [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Return a group's members
     * @param $groupname
     * @return NextcloudResponse
     */
    public function getGroupUsers($groupname) {

        return $this->client->request(self::GET, self::GROUP_PART . '/' . $groupname);
    }

    /**
     * Returna group's subadmins
     * @param $groupname
     * @return NextcloudResponse
     */
    public function getGroupSubadmins($groupname) {

        return $this->client->request(self::GET, self::GROUP_PART . '/' . $groupname . '/subadmins');
    }

    /**
     * Deletes a group
     * @param $groupname
     * @return NextcloudResponse
     */
    public function deleteGroup($groupname) {

        return $this->client->request(self::DELETE, self::GROUP_PART . '/' . $groupname);
    }

    /**
     * Gets a list of apps
     * @param null $filter can be either 'enabled' or 'disabled' to filter apps
     * @return NextcloudResponse
     */
    public function getApps($filter = null) {

        return $this->client->request(self::GET, self::APP_PART . $this->client->buildUriParams([
                'filter'    => $filter
            ]));
    }

    /**
     * Returns infos for an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function getAppInfo($appname) {

        return $this->client->request(self::GET, self::APP_PART . '/' . $appname);
    }

    /**
     * Enables an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function enableApp($appname) {

        return $this->client->request(self::POST, self::APP_PART . '/' . $appname);
    }

    /**
     * Disables an app
     * @param $appname
     * @return NextcloudResponse
     */
    public function disableApp($appname) {

        return $this->client->request(self::DELETE, self::APP_PART . '/' . $appname);
    }

}