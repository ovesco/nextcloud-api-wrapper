<?php

namespace NextcloudApiWrapper;

class GroupsClient extends AbstractClient
{
    const   GROUP_PART   = 'v1.php/cloud/groups';

    /**
     * Search for groups
     * @param $search
     * @return NextcloudResponse
     */
    public function searchGroups($search = '') {

        return $this->connection->request(Connection::GET, self::GROUP_PART . $this->connection->buildUriParams([
                'search'    => $search
            ]));
    }

    /**
     * Creates a new group
     * @param $groupname
     * @return NextcloudResponse
     */
    public function createGroup($groupname) {

        return $this->connection->submitRequest(Connection::POST, self::GROUP_PART, [
            'groupid'   => $groupname
        ]);
    }

    /**
     * Return a group's members
     * @param $groupname
     * @return NextcloudResponse
     */
    public function getGroupUsers($groupname) {

        return $this->connection->request(Connection::GET, self::GROUP_PART . '/' . $groupname);
    }

    /**
     * Returna group's subadmins
     * @param $groupname
     * @return NextcloudResponse
     */
    public function getGroupSubadmins($groupname) {

        return $this->connection->request(Connection::GET, self::GROUP_PART . '/' . $groupname . '/subadmins');
    }

    /**
     * Deletes a group
     * @param $groupname
     * @return NextcloudResponse
     */
    public function deleteGroup($groupname) {

        return $this->connection->request(Connection::DELETE, self::GROUP_PART . '/' . $groupname);
    }
}