<?php

use api\controllers\ApiController;
use controllers\SiteController;

require_once 'vendor/autoload.php';
require_once 'api/controllers/ApiController.php';
require_once 'controllers/SiteController.php';


$request_api = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if ($request_api[0] == 'api') {
    $api = new ApiController();
    echo $api->run();
} else {
    $app = new SiteController();
    echo $app->run();
}