<?php 

namespace Fin\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Fin\Models\Products;
use Fin\Trolley\Trolley;

class HomeController {
    public function index($request, $response, Twig $view, Products $prod){
        
        $data["products"] = $prod->get() ;
        
        $view->render($response, "home.twig", $data);
    }
}

?>

