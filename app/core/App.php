<?php
namespace App\core;
use App\core\Database;
use App\core\Router;
use App\core\Session;
use App\repository\ClientRepository;
use App\repository\ReçuRepository;
use App\service\ClientService;
use App\service\ReçuService;

class App{
    private static Array  $dependencies=[];
    public static function init(){

        self::registerDependance('router' , (new Router()));
        self::registerDependance('database' , Database::getInstance());
        self::registerDependance('clientrepository' , ClientRepository::getInstance());
        self::registerDependance('clientservice' , ClientService::getInstance());
        self::registerDependance('session',Session::getInstance());
        self::registerDependance('reçurepository',ReçuRepository::getInstance());
        self::registerDependance('reçuservice',ReçuService::getInstance());
      

    }
    public static function getDependencie($key){

        if(array_key_exists($key,self::$dependencies)){
            return self::$dependencies[$key];
        }
        throw new \Error('Dependance non trouvée...');      
    }

    public static function registerDependance($key , $dependence){
        if (!array_key_exists($key , self::$dependencies)) {
            self::$dependencies[$key] = $dependence;
        }else{
            return null;
        }
    }

}