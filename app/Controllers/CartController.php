<?php 

namespace Fin\Controllers;

use Slim\Router;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Fin\Models\Products;
use Fin\Trolley\Trolley;
use Fin\Exceptions\BasketException;


class CartController {


    protected $basket; 
    protected $product;

    public function __construct(Trolley $basket,Products $product)
    {
        $this->basket = $basket;
        $this->product = $product;
    }

    public function index($request, $response, Twig $view, Products $prod, Router $router ){
        $this->basket->resync();
        $view->render($response, "billing/charges.twig" );
    }

    public function add($id, $qty, Response $response, Router $router, Request $request)
    {
    
        $product = $this->product->where("id",$id)->first();
    
        if(!$product){
    
            return $response->withRedirect($router->pathFor('home'));
    
        }

        try {
            $this->basket->add($product, $qty);
            
        } catch (BasketException $e) {
            
            pf($e->message);
        }

        return $response->withRedirect($router->pathFor('charge.base'));
    }

    public function update($id, Request $request, Response $response, Router $rtr)
    {
        
        $product = $this->product->where("id",$id)->first();

        if(!$product){

            return $response->withRedirect($rtr->pathFor('home'));

        }
        try {
            $this->basket->update($product, $request->getParam('qty'));
        } catch ( BasketException $e ) {
            //throw $th;
        }

        return $response->withRedirect($rtr->pathFor('charge.base'));
    }
}

?>

