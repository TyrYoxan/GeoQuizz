<?php

use Psr\Container\ContainerInterface;
use gateway\application\actions\PostSignIn;

return [

    "guzzle.client" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            // Base URI pour des requêtes relatives
            //'base_uri' => $c->get(''),
        ]);
    },
    "guzzle.client.auth" => function (ContainerInterface $c) {
        return new GuzzleHttp\Client([
            // Base URI pour des requêtes relatives
            'base_uri' => $c->get('auth.api'),
        ]);
    },
];
