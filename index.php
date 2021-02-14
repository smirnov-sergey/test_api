<?php

use api\controllers\UsersController;
use GuzzleHttp\Client;

require_once 'vendor/autoload.php';
require_once 'api/controllers/UsersController.php';
require_once 'api/models/UsersApi.php';


/**
 * тест работы Guzzle
 */
//$client = new Client(['base_uri' => 'http://httpbin.org']);
//$response = $client->request('GET', '/ip', [
//    'query' => [
//    ],
//    'headers' => [
//        'Access-Control-Allow-Origin' => '*',
//        'Access-Control-Allow-Methods' => '*',
//        'Content-Type' => 'application/json'
//    ]
//]);
//
//echo ' response Status: ' . $response->getStatusCode();
//echo '<pre>';
//print_r(get_class_methods($response));
//echo '</pre>';


try {
    $users_api = new UsersController();
    echo $users_api->run();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}