<?php

use api_geoquizz\application\actions\CreatePartieAction;
use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\application\actions\GetProfilAction;
use api_geoquizz\application\actions\UpdatePartieAction;
use api_geoquizz\application\providers\JWTManager;
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

    'client.directus' => function(ContainerInterface $c){
        return new GuzzleHttp\Client([
            'base_uri' => 'http://directus:8055',
            'timeout' => 2.0,
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

    JWTManager::class=> DI\autowire(JWTManager::class),

    'PartieRepository' => function(ContainerInterface $c){
        return new PartieRepository($c->get('partie.pdo'));
    },

    // Enregistrement de l'interface ServicePartieInterface
    ServicePartieInterface::class => function(ContainerInterface $c) {
        return new ServicePartie($c->get('PartieRepository'));
    },

    GetPartieAction::class => function(ContainerInterface $c) {
        return new GetPartieAction($c->get(ServicePartieInterface::class));
    },

    CreatePartieAction::class=> function(ContainerInterface $c) {
        return new CreatePartieAction($c->get(ServicePartieInterface::class),
                                      $c->get('client.directus'),
                                      $c->get(JWTManager::class));
    },

    GetProfilAction::class => function(ContainerInterface $c) {
        return new GetProfilAction($c->get(JWTManager::class),
                                   $c->get(ServicePartieInterface::class));
    },

    UpdatePArtieAction::class=> function(ContainerInterface $c) {
        return new UpdatePartieAction($c->get(ServicePartieInterface::class));
    }
];