<?php

namespace api_geoquizz\core\services\partie;

use api_geoquizz\core\dto\DTOPartie;
use api_geoquizz\core\dto\InputPartieDTO;

interface ServicePartieInterface
{
    public function createPartie(InputPartieDTO $partie): String;
    public function updatePartie(DTOPartie $partie): void;
    public function getPartie($id);
    public function getUserParties(String $id): array;
    public function createSequence(String $sequence, String $name);
}