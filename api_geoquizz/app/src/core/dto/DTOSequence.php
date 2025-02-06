<?php

namespace api_geoquizz\core\dto;

use api_geoquizz\core\domain\entities\sequence\Sequence;

class DTOSequence extends DTO implements \JsonSerializable
{
    protected String $id;
    protected String $name;
    protected String $sequence;
    protected bool $status;
    public function __construct(Sequence $sequence){
        $this->id=$sequence->id;
        $this->name=$sequence->name;
        $this->sequence=$sequence->sequence;
        $this->status=$sequence->status;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sequence' => $this->sequence,
            'status' => $this->status,
        ];
    }
}