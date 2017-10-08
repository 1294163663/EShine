<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/query_result', '\EShine\Controller\NewPeopleController:getApplyStatus')->setName('queryResult');
$app->post('/apply', '\EShine\Controller\NewPeopleController:newApply')->setName('apply');
$app->get('/excel', '\EShine\Controller\NewPeopleController:getNewPeopleExcel')->setName('out');

$app->get('/eshine', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.html', $args);
})->setName('show');

$app->get('/query', function (Request $request, Response $response, array $args) {
//    $this->logger->info("Slim-Skeleton '/' route");
    return $this->renderer->render($response, 'query.html', $args);
})->setName('query');

$app->get('/sign_up', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'sign_up.html', $args);
})->setName('sign_up');

$app->get('/[{extra}]', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.html', $args);
});



