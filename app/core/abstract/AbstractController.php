<?php
namespace App\Core\Abstract;

use App\core\App;
use App\core\Session;

abstract class AbstractController{
    
    protected Session $session ;
    public function __construct(){
        $this->session= App::getDependencie('session');
    }
    public function render($view,$data=[]){
        ob_start();
        extract($data);
        ob_get_clean();
    }
    abstract public function create();
    abstract public function show();
    abstract public function update();
    abstract public function destroy();
    abstract public function index();
    abstract public function store();
    abstract public function edit(); 
}