<?php

namespace api_geoquizz\core\domain\entities\partie;


use api_geoquizz\core\domain\entities\sequence\Sequence;
use api_geoquizz\core\dto\DTO;
use api_geoquizz\core\dto\DTOPartie;

class Partie extends DTO
{
    protected Sequence $sequence_photo;
    protected int $score;
    /**
     * @param mixed $sequence_photo
     * @param mixed $score
     */
    public function __construct(Sequence $sequence_photo, int $score)
    {
        $this->sequence_photo = $sequence_photo;
        $this->score = $score;
    }

    public function toDTO(): DTOPartie{
        return new DTOPartie($this);
    }

}