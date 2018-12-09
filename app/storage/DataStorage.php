<?php 


namespace Fin\Storage;

use Fin\Storage\Support\StorageInterface;
use Countable;


class DataStorage implements StorageInterface, Countable {

    protected $trolley;

    public function __construct($trolley = 'Basket1')
    {
        if(!isset($_SESSION[$trolley])){
            $_SESSION[$trolley] = array();  
        }

        $this->trolley = $trolley;
    }

    public function set($index, $value)
    {
        $_SESSION[$this->trolley][$index] = $value;
    }
    

    public function get($index)
    {
        if(!$this->exists($index)) return null;
        return    $_SESSION[$this->trolley][$index];
    }

    public function exists($index){
        return isset($_SESSION[$this->trolley][$index]);
    }

    public function all(){
        return $_SESSION[$this->trolley];
    }

    public function unset($index){
        if($this->exists($index)){
            unset($_SESSION[$this->trolley][$index]);
        }
    }

    public function clear(){
        unset($_SESSION[$this->trolley]);
    }

    public function count(){
        return count($this->all());
    }

}