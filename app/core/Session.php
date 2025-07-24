<?php
namespace App\core;
class Session{
    private static ?Session $instance=null;
    
    private function __construct(){
        if (session_status()===PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getInstance(): Session{
        if(self::$instance===null){
            self::$instance=new self();
        }
        return self::$instance;

    }
    public function set($key, $value){

        $_SESSION[$key]=$value;
    }
    public function get($key){

       return  $_SESSION[$key] ??null;

    }
    public function unset($key, $value){

        unset($_SESSION[$key]);
    }
    public function destroy(){
        $_SESSION=[];
        if(session_status()===PHP_SESSION_ACTIVE){
            session_destroy();
            self::$instance=null;
        }
     }

    public function isset($key):bool{
        return isset ($_SESSION[$key]);
    }    
    
}


