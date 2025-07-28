<?php
namespace App\controller;

use App\core\App;

class ApiController {
    public function index() {
        header('Content-Type: application/json');
        $reçuService = App::getDependencie('reçuservice');
        echo $reçuService->getAllReçusAsJson();
    }
}