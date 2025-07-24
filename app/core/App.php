<?php
namespace App\core;
use App\core\Database;
use App\core\Router;
use App\core\Session;
use App\repository\CitoyenRepository;
use App\service\CitoyenService;

class App{
    private static Array  $dependencies=[];
    public static function init(){

        self::registerDependance('router' , (new Router()));
        self::registerDependance('database' , Database::getInstance());
        self::registerDependance('citoyenrepository' , CitoyenRepository::getInstance());
        self::registerDependance('citoyenservice' , CitoyenService::getInstance());
        self::registerDependance('session',Session::getInstance());
       // self::registerDependance('journalrepository',JournalRepository::getInstance());
       // self::registerDependance('journalservice',JournalService::getInstance());
      

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