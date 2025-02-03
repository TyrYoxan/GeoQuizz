<?php

namespace api_geoquizz\core\dto;

class InputPartieDTO extends DTO
{
    protected String $sequence_photo;
    protected int $score;

    public function __construct(array $data)
    {
        $this->sequence_photo = $data['sequence_photo'];
        $this->score = $data['score'];
    }

}