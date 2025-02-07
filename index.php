<?php

require __DIR__ . '/vendor/autoload.php';

use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;
use NYPL\Starter\ErrorHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

try {
    Config::initialize(__DIR__ . '/config');

    $service = new Service();

    $service->addBodyParsingMiddleware();

    $afterMiddleware = function (Request $request, RequestHandler $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type,X-Amz-Date,Authorization,X-Api-Key,X-Amz-Security-Token')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('X-NYPL-Original-Request', $request->getUri()->__toString())
            ->withHeader('X-NYPL-Response-Date', date('c'));
    };

    $service->add($afterMiddleware);

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

    $service->post("/api/v0.1/item-post-requests", function (Request $request, Response $response) {
        $controller = new Controller\BasePostController\ItemPostController($request, $response);
        return $controller->createItemPostRequest();
    });

    $service->run();
} catch (Exception $exception) {
    ErrorHandler::processShutdownError($exception->getMessage(), $exception);
}
