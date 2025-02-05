<?php
declare(strict_types=1);

use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericDirectusAction;
use gateway\application\actions\GenericGeoquizzAction;
use gateway\middlewares\CorsMiddleware;
use Slim\Exception\HttpNotFoundException;
use gateway\application\actions\HomeAction;

return function (\Slim\App $app): \Slim\App {
    $app->add(CorsMiddleware::class);
    $app->get('/', HomeAction::class);

    $app->get('/tokens/validate', GenericAuthAction::class);
    $app->post('/signin[/]', GenericAuthAction::class)->setName('signIn');
    $app->post('/signup[/]', GenericAuthAction::class)->setName('signUp');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    // Service Geoquizz
    $app->get('/profil', GenericGeoquizzAction::class)->setName('profil');
    $app->get('/parties/{id}', GenericGeoquizzAction::class)->setName('getPartie');
    $app->post('/parties/create', GenericGeoquizzAction::class)->setName('createPartie');
    $app->patch('/parties/update', GenericGeoquizzAction::class)->setName('updatePartie');

    // Service Directus
    $app->get('/directus/{id}', GenericDirectusAction::class)->setName('getImage');

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });    

    return $app;
};
