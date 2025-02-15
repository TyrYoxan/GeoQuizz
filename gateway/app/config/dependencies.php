<?php

use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericDirectusAction;
use gateway\application\actions\GenericGeoquizzAction;
use gateway\middlewares\AuthMiddleware;
use gateway\middlewares\PartieMiddleware;
use Psr\Container\ContainerInterface;
return [

    "client.auth" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api_auth:80',
        ]);
    },
    "client.geoquizz" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api_geoquizz:80',
        ]);
    },
    "client.directus" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://directus:8055',
        ]);
    },

    AuthMiddleware::class => function(ContainerInterface $c) {
        return new AuthMiddleware($c->get('client.auth'));
    },

    PartieMiddleware::class => function(ContainerInterface $c) {
        return new PartieMiddleware($c->get('client.geoquizz'));
    },

    GenericGeoquizzAction::class => function (ContainerInterface $c) {
        return new GenericGeoquizzAction($c->get('client.geoquizz'));
    },

    GenericAuthAction::class => function (ContainerInterface $c) {
        return new GenericAuthAction($c->get('client.auth'));
    },

    GenericDirectusAction::class => function (ContainerInterface $c) {
        return new GenericDirectusAction($c->get('client.directus'));
    }
];
