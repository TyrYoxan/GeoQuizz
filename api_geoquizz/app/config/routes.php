<?php
declare(strict_types=1);


use api_geoquizz\application\actions\CreatePartieAction;
use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\application\actions\HomeAction;

return function(\Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/parties/{id}', GetPartieAction::class)->setName('partie');
    $app->post('/parties/create', CreatePartieAction::class)->setName('create');


    return $app;
};
