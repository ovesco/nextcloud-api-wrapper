<?php

namespace NextcloudApiWrapper;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SharesClient extends AbstractClient
{
    const SHARE_PART    = 'v2.php/apps/files_sharing/api/v1/shares';

    /**
     * Get all shares from the user
     * @return NextcloudResponse
     */
    public function getAllShares() {

        return $this->connection->request(Connection::GET, self::SHARE_PART);
    }

    /**
     * Get all shares from a given file/folder
     * @param $path
     * @param array $params, can have keys 'reshares' (bool), 'subfiles' (bool)
     * @return NextcloudResponse
     */
    public function getSharesFromFileOrFolder($path, array $params) {

        $params = $this->resolve($params, function(OptionsResolver $resolver) {
            $resolver->setDefaults([
                'reshares',
                'subfiles'
            ]);
        });

        $params = array_merge($params, ['path' => $path]);

        return $this->connection->request(Connection::GET, self::SHARE_PART . '/' . $this->buildUriParams($params));
    }

    /**
     * Get information about a given share
     * @param $shareid
     * @return NextcloudResponse
     */
    public function getShareInformation($shareid) {

        return $this->connection->request(Connection::GET, self::SHARE_PART . '/' . $shareid);
    }

    /**
     * Share a file/folder with a user/group or as public link
     * @param array $params
     * @return NextcloudResponse
     */
    public function createShare(array $params) {

        $params = $this->resolve($params, function(OptionsResolver $resolver) {
            $resolver->setRequired([
                'path',
                'shareType'
            ])->setDefaults([
                'shareWith'     => null,
                'publicUpload'  => null,
                'password'      => null,
                'permissions'   => null,
                'expireDate'    => null
            ]);
        });

        return $this->connection->submitRequest(Connection::POST, self::SHARE_PART, $params);
    }

    /**
     * Remove the given share
     * @param $shareid
     * @return NextcloudResponse
     */
    public function deleteShare($shareid) {

        return $this->connection->request(Connection::DELETE, self::SHARE_PART . '/' . $shareid);
    }

    /**
     * Update a given share. Only one value can be updated per request
     * @param $shareid
     * @param $key
     * @param $value
     * @return NextcloudResponse
     */
    public function updateShare($shareid, $key, $value) {

        $this->inArray($key, ['permissions', 'password', 'publicUpload', 'expireDate']);

        return $this->connection->pushDataRequest(Connection::PUT, self::SHARE_PART . '/' . $shareid, [
            $key => $value
        ]);
    }
}
