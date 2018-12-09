<?php 


use Fin\App;
use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App;


$capsule = new Capsule;
$capsule->addConnection([
    'host'=>'localhost',
    'database'=>'fin',
    'username'=>'root',
    'password'=>'',
    'driver'=>'mysql',
    // 'charset'=>'utf8',
    // 'collation'=>'utf8_unicode_ci',
    // 'prefix'=>'',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require __DIR__ . '/../app/routes.php';


function pf($i){
    echo '<pre>';
    print_r($i);
    echo '</pre>';
}