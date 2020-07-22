<?php


namespace NextcloudApiWrapper\WebDAV;


final class XMLTypesEnum
{

    const XML_TYPE_ALIASES = 'xmlns:d="DAV:" xmlns:oc="http://owncloud.org/ns" xmlns:nc="http://nextcloud.org/ns"';
    const FOLDER_PARAMS_TO_XML_TYPE =
        [
            "getlastmodified" => "d:getlastmodified",
            "getetag" => "d:getetag",
            "getcontenttype" => "d:getcontenttype",
            "resourcetype" => "d:resourcetype",
            "getcontentlength" => "d:getcontentlength",
            "id" => "oc:id", // The fileid namespaced by the instance id, globally unique
            "fileid" => "oc:fileid", // fileid The unique id for the file within the instance
            "favorite" => "oc:favorite",
            "comments-href" => "oc:comments-href",
            "comments-count" =>  "oc:comments-count",
            "comments-unread" => "oc:comments-unread",
            "owner-id" => "oc:owner-id", // The user id of the owner of a shared file
            "owner-display-name" => "oc:owner-display-name", // The display name of the owner of a shared file
            "share-types" => "oc:share-types",
            "checksums" => "oc:checksums",
            "has-preview" => "ns:has-preview",
            "size" => "oc:size", // Unlike getcontentlength, this property also works for folders reporting the size of everything in the folder.
        ];

    const FAVOURITE_PARAMS_TO_XML_TYPE = [
        "favorite" => "oc:favourite",
    ];
}