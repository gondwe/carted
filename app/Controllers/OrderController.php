<?php 

namespace Fin\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Fin\Models\Products;
use Fin\Trolley\Trolley;
use Slim\Router;
use Fin\Validation\Support\ValidationInterface;
use Fin\Validation\Forms\OrderValidation;


class OrderController {

    protected $basket;

    protected $validator;

    function __construct(Trolley $basket, ValidationInterface $validator)
    {
        $this->basket = $basket;
        $this->validator = $validator;
    }

    public function index($request, $response, Twig $view, Router $rtr)
    {

        $this->basketrefresh($response, $rtr);
        
        $view->render($response, "orders/index.twig");

    }

    public function create($request, $response, Router $rtr)
    {
        $this->basketrefresh($response, $rtr);

        // validate
        
        $validation = $this->validator->validate($request, OrderValidation::rules());

        if($validation->fails()){
            return $response->withRedirect($rtr->pathFor('orders'));
        }

        die('work');


    }

    protected function basketrefresh($response, $rtr){
        $this->basket->resync();

        if(!$this->basket->subTotal()){

            return $response->withRedirect($rtr->pathFor('charge.base'));

        }
    }
}

?>

