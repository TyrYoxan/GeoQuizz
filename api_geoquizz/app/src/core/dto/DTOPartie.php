<?php

namespace api_geoquizz\core\dto;

use api_geoquizz\core\domain\entities\partie\Partie;
use api_geoquizz\core\domain\entities\sequence\Sequence;

class DTOPartie extends DTO implements \JsonSerializable
{
    protected DTOSequence $sequence_photo;
    protected int $score;
    public function __construct(Partie $partie)
    {
        $this->sequence_photo = new DTOSequence($partie->sequence_photo);
        $this->score = $partie->score;
    }

    public function jsonSerialize(): array
    {
        return [
           'sequence' => $this->sequence_photo,
           'score' => $this->score
        ];
    }
}