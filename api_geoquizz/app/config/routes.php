<?php
declare(strict_types=1);


use api_geoquizz\application\actions\CreatePartieAction;
use api_geoquizz\application\actions\GetPartieAction;
use api_geoquizz\application\actions\GetProfilAction;
use api_geoquizz\application\actions\GetSequenceAction;
use api_geoquizz\application\actions\GetSequencesAction;
use api_geoquizz\application\actions\GetThemeAction;
use api_geoquizz\application\actions\HomeAction;
use api_geoquizz\application\actions\UpdatePartieAction;
use api_geoquizz\application\actions\UpdateSequenceAction;

return function(\Slim\App $app): \Slim\App {

    // Routes
    $app->get('/', HomeAction::class)->setName('home');

    // Parties
    $app->get('/parties/{id}', GetPartieAction::class)->setName('partie');
    $app->post('/parties/create', CreatePartieAction::class)->setName('create');
    $app->patch('/parties/update', UpdatePartieAction::class)->setName('update');

    // Sequences
    $app->get('/sequences', GetSequencesAction::class)->setName('sequences');
    $app->get('/sequences/themes', GetThemeAction::class)->setName('theme');
    $app->get('/sequences/{id}', GetSequenceAction::class)->setName('sequence');
    $app->patch('/sequences/{id}', UpdateSequenceAction::class)->setName('update_sequence');

    // Profile
    $app->get('/profil', GetProfilAction::class)->setName('profil');

    return $app;
};
