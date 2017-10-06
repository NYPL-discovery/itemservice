<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;
use NYPL\Starter\ErrorHandler;

try {
    Config::initialize(__DIR__);

    $service = new Service();

    $service->get("/docs/item", function (Request $request, Response $response) {
        return SwaggerGenerator::generate(
            [__DIR__ . "/src", __DIR__ . "/vendor/nypl/microservice-starter/src"],
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

    $service->get("/api/v0.1/items-temp", function (Request $request, Response $response) {
        $controller = new Controller\ItemController($request, $response);
        return $controller->getItems();
    });

    $service->get("/api/v0.1/items/{nyplSource}/{id}", function (Request $request, Response $response, $parameters) {
        $controller = new Controller\ItemController($request, $response);
        return $controller->getItem($parameters["nyplSource"], $parameters["id"]);
    });

    $service->get(
        "/api/v0.1/bibs/{nyplSource}/{id}/items",
        function (Request $request, Response $response, $parameters) {
            $controller = new Controller\BibController($request, $response);
            return $controller->getBibItems($parameters["nyplSource"], $parameters["id"]);
        }
    );

    $service->post(
        "/api/v0.1/bibs/{nyplSource}/{id}/items",
        function (Request $request, Response $response, $parameters) {
            $controller = new Controller\BibController($request, $response);
            return $controller->createBibItem($parameters["nyplSource"], $parameters["id"]);
        }
    );

    $service->get(
        "/api/v0.1/items/{nyplSource}/{id}/catalog-redirect",
        function (Request $request, Response $response, $parameters) {
            $controller = new Controller\ItemController($request, $response);
            return $controller->redirectToCatalog($parameters["nyplSource"], $parameters["id"]);
        }
    );

    $service->run();
} catch (Exception $exception) {
    ErrorHandler::processShutdownError($exception->getMessage(), $exception);
}
