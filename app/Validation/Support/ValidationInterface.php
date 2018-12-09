<?php 


namespace Fin\Validation\Support;

use Psr\Http\Message\RequestInterface;


interface ValidationInterface {
    public function validate(RequestInterface $req, array $rules);
    public function fails();
}