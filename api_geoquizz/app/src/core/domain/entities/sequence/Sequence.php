<?php

namespace api_geoquizz\core\domain\entities\sequence;

use api_geoquizz\core\domain\entities\Entity;
use api_geoquizz\core\dto\DTO;
use api_geoquizz\core\dto\DTOSequence;

class Sequence extends DTO
{
    protected String $id;
    protected String $name;
    protected String $sequence;
    protected bool $status;

    public function __construct(String $id, string $name, string $sequence, bool $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sequence = $sequence;
        $this->status = $status;
    }

    public function toDTO(): DTOSequence{
        return new DTOSequence($this);
    }
}