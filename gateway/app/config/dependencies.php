<?php

use gateway\application\actions\GenericAuthAction;
use gateway\application\actions\GenericDirectusAction;
use gateway\application\actions\GenericGeoquizzAction;
use Psr\Container\ContainerInterface;
return [

    "client.auth" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api_auth:80',
            'timeout' => 3.0
        ]);
    },
    "client.geoquizz" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api_geoquizz:80',
            'timeout' => 2.0
        ]);
    },
    "client.directus" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            'base_uri' => 'http://directus:8055',
            'timeout' => 2.0
        ]);
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
