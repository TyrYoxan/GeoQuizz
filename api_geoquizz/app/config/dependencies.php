<?php

use Psr\Container\ContainerInterface;




return [
    'log.rdv.name' => 'toubeelib.log',
    'log.rdv.file' => __DIR__ . '/logs/toubeelib.rdv.log',
    'log.rdv.level' => \Monolog\Level::Debug,

    'logger.rdv' => function(ContainerInterface $c) {
        $logger = new \Monolog\Logger($c->get('log.rdv.name'));
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
                $c->get('log.rdv.file'),
                $c->get('log.rdv.level'))
        );

        return $logger;
    },

    'rdv.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db.toubeelib;dbname=rdv', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    },

    'praticien_client' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://api.praticiens:80',
            'timeout' => 2.0,
            'headers' => [
                'Origin' => 'http://api.rdv:80'
            ]
        ]);
    },

    'rdv_message_broker' => function(ContainerInterface $c){
        return new \PhpAmqpLib\Connection\AMQPStreamConnection(
            getenv('AMQP_HOST'),
            getenv('AMQP_PORT'),
            getenv('AMQP_USER'),
            getenv('AMQP_PASSWORD')
        );
    },

];