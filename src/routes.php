<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/show', '\EShine\Controller\NewPeopleController:show')->setName('show');
$app->get('/query', '\EShine\Controller\NewPeopleController:getApplyStatus')->setName('query');
$app->get('/apply', '\EShine\Controller\NewPeopleController:newApply')->setName('apply');
$app->get('/excel', '\EShine\Controller\NewPeopleController:getNewPeopleExcel')->setName('out');

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.html', $args);
});
