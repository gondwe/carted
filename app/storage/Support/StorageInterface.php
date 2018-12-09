<?php 


namespace Fin\Storage\Support;

interface StorageInterface {

    public function set($index, $value);

    public function get($index);

    public function unset($index);

    public function all();

}