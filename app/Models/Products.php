<?php 

namespace Fin\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {

    protected $lowLevel = 5;

    public function hasLowStock(){
        
        return ($this->outOfStock()) ? false : $this->stock <= $this->lowLevel;
        
    }

    
    public function outOfStock(){
        return $this->stock === 0;
    }

    
    public function inStock(){
        return $this->stock >= 1;
    }

    
    public function hasStock($qty){
        return $this->stock >= $qty;
    }

    
}