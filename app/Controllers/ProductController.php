<?php 

namespace Fin\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Fin\Models\Products;

class ProductController {
    public function get($request, $response, Twig $view, Products $prod, $id, Router $router ){

        $product = $prod->where("id", $id)->first();

        if(!$product) { return $response->withRedirect($router->pathFor('home'));}
        
        $view->render($response, "products/product.twig", array('product'=>$product));

    }
}


?>

