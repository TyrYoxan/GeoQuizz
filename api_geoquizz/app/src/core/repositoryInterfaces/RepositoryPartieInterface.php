<?php

namespace api_geoquizz\core\repositoryInterfaces;

use api_geoquizz\core\dto\InputPartieDTO;

interface RepositoryPartieInterface
{
    public function getPartie($id);
    public function createPartie(InputPartieDTO $partie);
    public function updatePartie($partie);

    public function getUserParties(String $id): array;
}