<?php
declare(strict_types=1);


use api_geoquizz\application\actions\CreatePartieAction;
use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\application\actions\GetProfilAction;
use api_geoquizz\application\actions\HomeAction;
use api_geoquizz\application\actions\UpdatePartieAction;

return function(\Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/parties/{id}', GetPartieAction::class)->setName('partie');
    $app->post('/parties/create', CreatePartieAction::class)->setName('create');
    $app->patch('/parties/update', UpdatePartieAction::class)->setName('update');

    $app->get('/profil', GetProfilAction::class)->setName('profil');

    return $app;
};
