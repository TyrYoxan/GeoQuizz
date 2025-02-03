<?php
declare(strict_types=1);


return function( \Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');



    return $app;
};
