<?php

use App\core\App;
use App\core\Router;

// Start output buffering at the very beginning
ob_start();

require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/env.php';
 
require_once '../routes/route.web.php';

App::init();
$session = App::getDependencie('session');

Router::resolve($routes);







