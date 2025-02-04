<?php
declare(strict_types=1);

use api_auth\application\actions\HomeAction;
use api_auth\application\actions\TokenValidation;
use Slim\Exception\HttpNotFoundException;

use api_auth\application\actions\PostSignIn;
use api_auth\application\actions\PostSignUp;

return function (\Slim\App $app): \Slim\App {

    $app->get('/', HomeAction::class);

    $app->get('/tokens/validate[/]', TokenValidation::class);

    $app->post('/signin[/]', PostSignIn::class)->setName('signIn');

    $app->post('/signup[/]', PostSignUp::class)->setName('signUp');

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

    return $app;
};