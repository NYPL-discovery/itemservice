<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;

Config::initialize(__DIR__ . '/config');

$service = new Service();

$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(
        [__DIR__ . "/src"],
        $response
    );
});

$service->post("/api/v0.1/items", function (Request $request, Response $response) {
    $controller = new Controller\ItemController($request, $response);
    return $controller->createItem();
});

$service->get("/api/v0.1/items", function (Request $request, Response $response) {
    $controller = new Controller\ItemController($request, $response);
    return $controller->getItems();
});

$service->get("/api/v0.1/items/{nyplSource}/{id}", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\ItemController($request, $response);
    return $controller->getItem($parameters["nyplSource"], $parameters["id"]);
});


$service->get("/api/v0.1/bibs/{nyplSource}/{id}/items", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\ItemController($request, $response);
    return $controller->getItems($parameters["nyplSource"], $parameters["id"]);
});

$service->post("/api/v0.1/bibs/{nyplSource}/{id}/items", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\ItemController($request, $response);
    return $controller->createItem($parameters["nyplSource"], $parameters["id"]);
});

$service->run();
