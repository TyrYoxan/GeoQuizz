<?php

use api_geoquizz\application\actions\CreatePartieAction;
use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\application\actions\GetProfilAction;
use api_geoquizz\application\actions\GetSequenceAction;
use api_geoquizz\application\actions\GetSequencesAction;
use api_geoquizz\application\actions\GetThemeAction;
use api_geoquizz\application\actions\UpdatePartieAction;
use api_geoquizz\application\actions\UpdateSequenceAction;
use api_geoquizz\application\providers\JWTManager;
use api_geoquizz\core\services\partie\ServicePartie;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use api_geoquizz\core\services\sequence\ServiceSequence;
use api_geoquizz\core\services\sequence\ServiceSequenceInterface;
use api_geoquizz\infrastructure\repository\PartieRepository;
use api_geoquizz\infrastructure\repository\RepositorySequence;
use Psr\Container\ContainerInterface;

return [

    'pdo' => function(ContainerInterface $c) {
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

    'message_broker' => function(ContainerInterface $c){
        return new \PhpAmqpLib\Connection\AMQPStreamConnection(
            getenv('AMQP_HOST'),
            getenv('AMQP_PORT'),
            getenv('AMQP_USER'),
            getenv('AMQP_PASSWORD')
        );
    },

    JWTManager::class=> DI\autowire(JWTManager::class),

    'PartieRepository' => function(ContainerInterface $c){
        return new PartieRepository($c->get('pdo'));
    },

    'SequenceRepository' => function(ContainerInterface $c){
    return new RepositorySequence($c->get('pdo'));
    },

    // Enregistrement de l'interface ServicePartieInterface
    ServicePartieInterface::class => function(ContainerInterface $c) {
        return new ServicePartie($c->get('PartieRepository'));
    },

    ServiceSequenceInterface::class => function(ContainerInterface $c) {
        return new ServiceSequence($c->get('SequenceRepository'));
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
        return new UpdatePartieAction($c->get(ServicePartieInterface::class), $c->get(JWTManager::class));
    },

    GetSequencesAction::class=> function(ContainerInterface $c) {
        return new GetSequencesAction($c->get(ServiceSequenceInterface::class));
    },

    GetSequenceAction::class=> function(ContainerInterface $c) {
        return new GetSequenceAction($c->get(ServiceSequenceInterface::class));
    },

    UpdateSequenceAction::class=> function(ContainerInterface $c) {
        return new UpdateSequenceAction($c->get(ServiceSequenceInterface::class));
    },

    GetThemeAction::class=> function(ContainerInterface $c) {
        return new GetThemeAction($c->get(ServiceSequenceInterface::class));
    }
];