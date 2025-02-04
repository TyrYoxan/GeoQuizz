<?php
declare(strict_types=1);

use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericGeoquizzAction;
use Slim\Exception\HttpNotFoundException;
use gateway\application\actions\HomeAction;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/tokens/validate', GenericAuthAction::class);
    $app->post('/signin[/]', GenericAuthAction::class)->setName('signIn');
    $app->post('/signup[/]', GenericAuthAction::class)->setName('signUp');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->get('/profil', GenericGeoquizzAction::class)->setName('profil');
    $app->get('/parties/{id}', GenericGeoquizzAction::class)->setName('getPartie');
    $app->post('/parties/create', GenericGeoquizzAction::class)->setName('createPartie');

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
