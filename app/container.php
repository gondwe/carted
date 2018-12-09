<?php 
use function DI\get;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;
use Fin\Models\Products;
use Fin\Storage\DataStorage;
use Fin\Storage\Support\StorageInterface;
use Fin\Trolley\Trolley;
use Fin\Validation\Support\ValidationInterface;
use Fin\Validation\Validator;



return [
    

    'router'=>get(Slim\Router::class),

    StorageInterface::class => function(ContainerInterface $c){
        return new DataStorage('MyCart');
    },

    ValidationInterface::class => function(ContainerInterface $c){
        return new Validator;
    },

    Twig::class => function(ContainerInterface $c) {
        $twig = new Twig(__DIR__ . '/../views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        $twig->getEnvironment()->addGlobal('mycart', $c->get(Trolley::class));

        return $twig;

    },


    Products::class => function(ContainerInterface $c){
        return new Products;
    },

    Trolley::class => function(ContainerInterface $c){
        return new Trolley(
            $c->get(DataStorage::class),
            $c->get(Products::class)
        );
    },
];