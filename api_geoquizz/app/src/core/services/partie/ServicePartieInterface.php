<?php

namespace api_geoquizz\core\services\partie;

use api_geoquizz\core\dto\DTOPartie;

interface ServicePartieInterface
{
    public function createPartie(DTOPartie $partie);
    public function updatePartie(DTOPartie $partie);

    public function getPartie($id);
}