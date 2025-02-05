<?php

namespace api_geoquizz\core\dto;

use api_geoquizz\core\domain\entities\partie\Partie;

class DTOPartie extends DTO implements \JsonSerializable
{
    protected String $sequence_photo;
    protected int $score;
    public function __construct(Partie $partie)
    {
        $this->sequence_photo = $partie->sequence_photo;
        $this->score = $partie->score;
    }

    public function jsonSerialize(): array
    {
        return [
           'sequence_photo' => $this->sequence_photo,
           'score' => $this->score
        ];
    }
}