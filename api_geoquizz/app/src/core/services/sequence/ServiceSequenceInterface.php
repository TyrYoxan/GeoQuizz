<?php

namespace api_geoquizz\core\services\sequence;

interface ServiceSequenceInterface
{
    public function getSequence($id);
    public function getAllSequences(): array;
    public function updateSequence($id): void;
    public function getThemes(): array;
}