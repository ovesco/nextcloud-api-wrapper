<?php

namespace NextcloudApiWrapper;

class FederatedCloudSharesClient extends AbstractClient
{
    const FCS_PART  = 'v2.php/apps/files_sharing/api/v1/remote_shares';

    /**
     * Get all federated cloud shares the user has accepted
     * @return NextcloudResponse
     */
    public function listAcceptedCloudShares() {

        return $this->connection->request(Connection::GET, self::FCS_PART);
    }

    /**
     * Get information about a given received federated cloud that was sent from a remote instance
     * @param $shareid
     * @return NextcloudResponse
     */
    public function getCloudShareInformation($shareid) {

        return $this->connection->request(Connection::GET, self::FCS_PART . '/' . $shareid);
    }

    /**
     * Locally delete a received federated cloud share that was sent from a remote instance
     * @param $shareid
     * @return NextcloudResponse
     */
    public function deleteCloudShare($shareid) {

        return $this->connection->request(Connection::DELETE, self::FCS_PART . '/' . $shareid);
    }

    /**
     * Get all pending federated cloud shares the user has received
     * @return NextcloudResponse
     */
    public function listPendingCloudShares() {

        return $this->connection->request(Connection::GET, self::FCS_PART . '/pending');
    }

    /**
     * Locally accept a received federated cloud share that was sent from a remote instance
     * @param $shareid
     * @return NextcloudResponse
     */
    public function acceptPendingCloudShare($shareid) {

        return $this->connection->request(Connection::POST, self::FCS_PART . '/pending/' . $shareid);
    }

    /**
     * Locally decline a received federated cloud share that was sent from a remote instance
     * @param $shareid
     * @return NextcloudResponse
     */
    public function declinePendingCloudShare($shareid) {

        return $this->connection->request(Connection::DELETE, self::FCS_PART . '/pending/' . $shareid);
    }
}