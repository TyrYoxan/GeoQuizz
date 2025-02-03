<?php

namespace api_geoquizz\core\services\partie;

use api_geoquizz\core\dto\DTOPartie;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use api_geoquizz\infrastructure\repository\PartieRepository;

class ServicePartie implements ServicePartieInterface
{
    private PartieRepository $repositoryPartie;

    public function __construct(PartieRepository $repositoryPartie)
    {
        $this->repositoryPartie = $repositoryPartie;
    }

    public function getPartie($id): DTOPartie
    {
        $partie = $this->repositoryPartie->getPartie($id);
        return $partie->toDTO();
    }

    public function createPartie(DTOPartie $partie)
    {
        // TODO: Implement createPartie() method.
    }

    public function updatePartie(DTOPartie $partie)
    {
        // TODO: Implement updatePartie() method.
    }
}