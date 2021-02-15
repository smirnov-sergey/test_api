<?php

use api\controllers\ApiController;
use controllers\SiteController;

//use GuzzleHttp\Client;

require_once 'vendor/autoload.php';
require_once 'api/controllers/ApiController.php';
require_once 'controllers/SiteController.php';


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
    $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

    if ($request_uri[0] == '/api') {
        $app = new ApiController();
        echo $app->run();
    } else {
        $app = new SiteController();
        echo $app->run();
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}