<?php

namespace NextcloudApiWrapper;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersClient extends AbstractClient
{
    const   USER_PART   = 'v1.php/cloud/users';

    /**
     * Adds a user.
     * @param $username
     * @param $password
     * @return NextcloudResponse
     */
    public function addUser($username, $password) {

        return $this->connection->submitRequest(Connection::POST, self::USER_PART, [
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

        $params = $this->connection->resolve($params, function(OptionsResolver $resolver) {
            $resolver->setDefaults([
                'search',
                'limit',
                'offset'
            ]);
        });

        return $this->connection->request(Connection::GET, self::USER_PART . $this->connection->buildUriParams($params));
    }

    /**
     * Gets data about a given user
     * @param $username
     * @return NextcloudResponse
     */
    public function getUser($username) {

        return $this->connection->request(Connection::GET, self::USER_PART . '/' . $username);
    }

    /**
     * Updates a user, sets the value identified by key to value
     * @param $username
     * @param $key
     * @param $value
     * @return NextcloudResponse
     */
    public function editUser($username, $key, $value) {

        $this->connection->inArray($key, [
            'email',
            'quota',
            'displayname',
            'phone',
            'address',
            'website',
            'twitter',
            'password'
        ]);

        return $this->connection->submitRequest(Connection::PUT, self::USER_PART . '/' . $username, [
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

        return $this->connection->pushDataRequest(Connection::PUT, self::USER_PART . '/' . $username . '/disable');
    }

    /**
     * Enables a user
     * @param $username
     * @return NextcloudResponse
     */
    public function enableUser($username) {

        return $this->connection->pushDataRequest(Connection::PUT, self::USER_PART . '/' . $username . '/enable');
    }

    /**
     * Deletes a user
     * @param $username
     * @return NextcloudResponse
     */
    public function deleteUser($username) {

        return $this->connection->request(Connection::DELETE, self::USER_PART . '/' . $username);
    }

    /**
     * Returns user's groups
     * @param $username
     * @return NextcloudResponse
     */
    public function getUserGroups($username) {

        return $this->connection->request(Connection::GET, self::USER_PART . '/' . $username . '/groups');
    }

    /**
     * Adds a user to a group
     * @param $username
     * @param $groupname
     * @return NextcloudResponse
     */
    public function addUserToGroup($username, $groupname) {

        return $this->connection->submitRequest(Connection::POST, self::USER_PART . '/' . $username . '/groups', [
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

        return $this->connection->submitRequest(Connection::DELETE, self::USER_PART . '/' . $username . '/groups', [
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

        return $this->connection->submitRequest(Connection::POST, self::USER_PART . '/' . $username . '/subadmins', [
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

        return $this->connection->submitRequest(Connection::DELETE, self::USER_PART . '/' . $username . '/subadmins', [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Returns all groups in which this user is subadmin
     * @param $username
     * @return NextcloudResponse
     */
    public function getUserSubadminGroups($username) {

        return $this->connection->request(Connection::GET, self::USER_PART . '/' . $username . '/subadmins');
    }

    /**
     * Resend the welcome mail
     * @param $username
     * @return NextcloudResponse
     */
    public function resendWelcomeEmail($username) {

        return $this->connection->request(Connection::POST, self::USER_PART . '/' . $username . '/welcome');
    }

}