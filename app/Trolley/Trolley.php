<?php 

namespace Fin\Trolley;

use Fin\Storage\Support\StorageInterface;
use Fin\Models\Products;
use Fin\Exceptions\BasketException;


class Trolley {


    protected $storage;
    protected $product;

    public function __construct( StorageInterface $storage, Products $product )
    {
        $this->storage = $storage;
        $this->product = $product;
    }


    public function add(Products $product, $qty) {
        
        if($this->has($product)){
            /* adjust qty */
            $qty = $this->get($product)["qty"] + $qty;
        }

        /* update product in data storage */
        $this->update($product, $qty); 

    }

    public function get(Products $product){
        return $this->storage->get($product->id);
    }

    public function has(Products $product){
        return $this->storage->exists($product->id);
    }

    public function update(Products $product, $qty){
        if (!$this->product->find($product->id)->hasStock($qty)){
            /* throw exception */
            throw new BasketException("Maybe something else");
        }

        if($qty == 0){
            $this->remove($product);
            return;
        }

        $this->storage->set($product->id, [
            'productId'=>$product->id,
            'qty'=>$qty,
        ]);
    }

    public function remove(Products $product){
        $this->storage->unset($product->id);
    }

    public function clear(){
        $this->storage->clear();
    }

    public function all(){
        $ids = []; 
        $items = [];
        foreach($this->storage->all() as $products){
            $ids[]=$products['productId'];
        }

        $products = $this->product->find($ids);

        foreach($products as $p){
            $p->qty = $this->get($p)['qty'];
            $items[] = $p;
        }

        return $items;

    }

    public function itemCount(){
        // count($this->storage->all());
        return count($this->storage);
    }

    public function subTotal(){

        $total = 0;

        foreach ($this->all() as $key => $item) {
            
            if ($item->outOfStock()) continue;

            $total += $item->price * $item->qty;

        }

        return $total;
    }

    public function resync()
    {
        foreach($this->all() as $item){
            if(!$item->hasStock($item->qty)){
                $this->update($item,$item->stock);
            }else if($item->hasStock(1) && $item->qty === 0){
                $this->update($item, 1);
            }
        }
    }


}