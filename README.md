# Nextcloud Provisioning API wrapper for PHP

This is a simple php wrapper around
- [user provisioning api](https://docs.nextcloud.com/server/12/admin_manual/configuration_user/user_provisioning_api.html)
- [shares api](https://docs.nextcloud.com/server/12/developer_manual/core/ocs-share-api.html)

which allows you to manage your nextcloud instance dynamically. It was
developed to be the closest possible to the API, every params is available
and method names should be understandable enough, dont hesitate to make
use of the api documentation for help on what params are available for each method.

##### Warning
> Nextcloud API uses basic http auth, which means username and password
are not encoded and travel the internet as clearly as possible. Make sure
to enforce it using SSL.

## Basic usage
The library depends on Guzzle to make requests and Symfony's options resolver.
```php

use NextcloudApiWrapper\Wrapper;

//The base path to Nextcloud api entry point, dont forget the last '/'
$basePath   = 'http://my.domain.com/nextcloud/ocs/';
$username   = 'admin';
$password   = 'potatoes';

$wrapper    = Wrapper::build($basePath, $username, $password);

// https://docs.nextcloud.com/server/12/admin_manual/configuration_user/user_provisioning_api.html
$userClient                 = $wrapper->getUsersClient();
$groupsClient               = $wrapper->getGroupsClient();
$appsClient                 = $wrapper->getAppsClient();

// https://docs.nextcloud.com/server/12/developer_manual/core/ocs-share-api.html
$sharesClient               = $wrapper->getSharesClient();
$federatedCloudSharesClient = $wrapper->getFederatedCloudSharesClient();

//Instance of \NextcloudApiWrapper\NextcloudResponse
$response   = $userClient->getUsers();
$code       = $response->getStatusCode();   //status code
$users      = $response->getData();         //data as array
$message    = $response->getStatus();       //status message
$guzzle     = $response->getRawResponse();  //Guzzle response
```

### Making your own requests
If you'd like to perform your own requests, you can use the underlying
nextcloud connection class to perform them.
```php
$connection = new NextcloudClient($basePath, $username, $password);

//To perform simple requests
$response   = $connection->request('GET', 'cloud/users');

//To perform requests which needs the 'application/x-www-form-urlencoded' header
//and are not performed in POST
$response   = $connection->pushDataRequest('PUT', 'cloud/' . $username . '/disable');

//To perform requests which holds some values to submit
$response   = $connection->submitRequest('POST', 'cloud/users', [
    'userid'    => 'potatoes',
    'password'  => 'tortilla'
]);
```