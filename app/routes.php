<?php 

$app->get('/', ['Fin\Controllers\HomeController','index'])->setName('home');

$app->get('/products/{id}', ['Fin\Controllers\ProductController','get'])->setName('product.get');

$app->get('/charges', ['Fin\Controllers\CartController','index'])->setName('charge.base');

$app->get('/charges/add/{id}/{qty}', ['Fin\Controllers\CartController','add'])->setName('charge.add');

$app->post('/charges/update/{id}', ['Fin\Controllers\CartController','update'])->setName('charge.update');

$app->get('/orders', ['Fin\Controllers\OrderController','index'])->setName('orders');

$app->post('/orders/create', ['Fin\Controllers\OrderController','create'])->setName('order.create');