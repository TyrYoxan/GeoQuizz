<?php

namespace api_geoquizz\core\repositoryInterfaces;

interface RepositorySequenceInterface
{
    public function getAllSequences(): array;
    public function getSequence($id);
    public function updateSequence($id): void;
}