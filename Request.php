<?php

namespace Sivka;

class Request {

    private $data;

    public function __construct($items = array()){
        $this->data = new \stdClass;
        $this->set($items);
    }

    public static function all($key = false){
        return self::request();
    }

    public static function request(){
        return self::setData($_REQUEST, $key);
    }

    public static function post($key = false){
        return self::setData($_POST, $key);
    }
    
    public static function files($key = false){
        return self::setData($_FILES, $key);
    }

    public static function cookie($key = false){
        return self::setData($_COOKIE, $key);
    }

    public static function server($key = false){
        return self::setData($_SERVER, $key);
    }

    public static function session($key = false){
        if(!isset($_SESSION)) \session_start();
        return self::setData($_SESSION, $key);
    }

    public static function headers($key = false){
        $headers = function_exists('getallheaders') ? \getallheaders() : \apache_request_headers();
        return self::setData($headers, $key);
    }

    public static function __callstatic($name, $arguments){ /// Request::get()
        if($name == 'get') return self::setData($_GET, isset($arguments[0]) ? $arguments[0] : false);
    }

    private static function setData($data, $key = false){
        $request = new self($data);
        return $request->_get($key);
    }

    ///////////////////////////////////////////////////////////////////

    public function set($items = array(), $value = false){
        if(!\is_array($items)){
            $this->data->$items = $value;
        }else{
            foreach ($items as $key => $val) $this->data->$key = $val;
        }
        return $this;
    }

    public function count(){
        return count( $this->toArray() );
    }

    public function toJson(){
        return json_encode( $this->toArray() );
    }

    public function toArray(){
        return (array)$this->data;
    }

    public function delete($key){
        if(isset($this->data->$key)) unset($this->data->$key);
        return $this;
    }

    public function __get($key){
        return $this->_get($key);
    }

    public function _get($key = false, $default = null){
        if($key !== false) return isset($this->data->$key) ? $this->data->$key : $default;
        return $this;
    }

    public function __set($key, $value){
        return $this->set($key, $value);
    }

    public function __call($name, $arguments){
        $arg2 = isset($arguments[1]) ? $arguments[1] : null;
        if($name == 'get') return $this->_get($arguments[0], $arg2);
        
        $arg2 = isset($arguments[1]) ? $arguments[1] : 0;
        if($name == 'int') return (int)$this->_get($arguments[0], $arg2);

        $arg2 = isset($arguments[1]) ? $arguments[1] : '';
        if($name == 'string') return (string)$this->_get($arguments[0], $arg2);
    }

    public function __toString(){
        return print_r($this->data, true);
    }

    public function has($key){
        return isset($this->data->$key);
    }

    public function keys(){
        return array_keys($this->toArray());
    }
    
}



