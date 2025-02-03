<?php

namespace api_geoquizz\core\repositoryInterfaces;

interface RepositoryPartieInterface
{
    public function getPartie($id);
    public function createPartie($partie);
    public function updatePartie($partie);
}