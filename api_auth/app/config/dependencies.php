<?php

use api_auth\core\repositoryInterfaces\AuthRepositoryInterface;
use api_auth\core\services\ServiceAuth;
use api_auth\core\services\ServiceAuthInterface;
use api_auth\infrastructure\repositories\PgAuthRepository;
use api_auth\application\middlewares\AuthnMiddleware;
use api_auth\application\middlewares\CorsMiddleware;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use api_auth\application\providers\auth\AuthnProviderInterface;
use api_auth\application\providers\auth\JWTAuthnProvider;
use api_auth\application\providers\auth\JWTManager;
use Psr\Container\ContainerInterface;


return [

    //Repository interface
    AuthRepositoryInterface::class=> DI\autowire(PgAuthRepository::class),

    //Services
    ServiceAuthInterface::class => DI\autowire(ServiceAuth::class),


    //PDO
    'pdo.commun' => function(ContainerInterface $c){
        $config= parse_ini_file($c->get('db.config'));
        return new PDO($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);
    },
    'pdo.auth' => function(ContainerInterface $c){
        $config = parse_ini_file($c->get('db.config'));
        var_dump($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);
        return new PDO($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);
    },
    

    //auth
    JWTManager::class=> DI\autowire(JWTManager::class),
    AuthnProviderInterface::class => DI\autowire(JWTAuthnProvider::class),
    
    StreamHandler::class => DI\create(StreamHandler::class)
        ->constructor(DI\get('logs.dir'), Logger::DEBUG)
        ->method('setFormatter', DI\get(LineFormatter::class)),

    
    LineFormatter::class => function() {
        $dateFormat = "Y-m-d H:i"; // Format de la date que tu veux
        $output = "[%datetime%] %channel%.%level_name%: %message% %context%\n"; // Format des logs
        return new LineFormatter($output, $dateFormat);
    },
    
    Logger::class => DI\create(Logger::class)->constructor('auth_logger', [DI\get(StreamHandler::class)]),


    //midleware 
    AuthnMiddleware::class => DI\autowire(AuthnMiddleware::class),
    CorsMiddleware::class => DI\autowire(CorsMiddleware::class),


];
//$co = new PDO('pgsql:host=auth.db;port=40002;dbname=auth;user=user;password=toto');
