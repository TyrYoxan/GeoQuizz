<?php

namespace api_geoquizz\core\services\sequence;

use api_geoquizz\core\dto\DTOSequence;
use api_geoquizz\core\services\sequence\ServiceSequenceInterface;
use api_geoquizz\infrastructure\repository\NotFoundSequenceException;
use api_geoquizz\infrastructure\repository\RepositorySequence;

class ServiceSequence implements ServiceSequenceInterface
{
    private RepositorySequence $repositorySequence;

    public function __construct(RepositorySequence $repositorySequence)
    {
        $this->repositorySequence = $repositorySequence;
    }

    public function getSequence($id): DTOSequence
    {
        try {
            $sequence = $this->repositorySequence->getSequence($id);
        } catch (NotFoundSequenceException $e) {
            throw new NotFoundSequenceException($e->getMessage());
        }
        return $sequence->toDTO();
    }

    public function getAllSequences(): array
    {
        return $this->repositorySequence->getAllSequences();
    }

    public function updateSequence($id): void
    {
        try {
            $this->repositorySequence->updateSequence($id);
        } catch (NotFoundSequenceException $e) {
            throw new NotFoundSequenceException($e->getMessage());
        }
    }
}