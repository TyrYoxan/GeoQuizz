<?php

use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\core\services\partie\ServicePartie;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use api_geoquizz\infrastructure\repository\PartieRepository;
use Psr\Container\ContainerInterface;

return [

    'partie.pdo' => function(ContainerInterface $c) {
        $pdo = new PDO('pgsql:host=db_geoquizz;dbname=geoquizz', 'geoquizz', 'geoquizz');
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

//    'rdv_message_broker' => function(ContainerInterface $c){
//        return new \PhpAmqpLib\Connection\AMQPStreamConnection(
//            getenv('AMQP_HOST'),
//            getenv('AMQP_PORT'),
//            getenv('AMQP_USER'),
//            getenv('AMQP_PASSWORD')
//        );
//    },

    'PartieRepository' => function(ContainerInterface $c){
        return new PartieRepository($c->get('partie.pdo'));
    },

    // Enregistrement de l'interface ServicePartieInterface
    ServicePartieInterface::class => function(ContainerInterface $c) {
        return new ServicePartie($c->get('PartieRepository'));
    },

    'GetPartie' => function(ContainerInterface $c) {
        return new GetPartieAction($c->get(ServicePartieInterface::class));
    }
];