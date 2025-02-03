<?php

namespace api_geoquizz\infrastructure\repository;

use api_geoquizz\core\dto\InputPartieDTO;
use api_geoquizz\core\repositoryInterfaces\RepositoryPartieInterface;
use api_geoquizz\core\domain\entities\partie\Partie;
use PDO;

class PartieRepository implements RepositoryPartieInterface
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getPartie($id): Partie
    {
        $data = $this->db->prepare("SELECT sequence_photo, user, score
                             FROM parties
                             WHERE id_partie = :id");
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        $row = $data->fetch();

        if(!$row) {
          throw new NotFoundPartieException("Partie with id " . $id . " not found");
        }

        return new Partie($row['sequence_photo'], $row['score']);
    }

    public function createPartie(InputPartieDTO $partie): void
    {
        $rq = $this->db->prepare("INSERT INTO parties
                             (sequence_photo, score) VALUES (:sequence_photo, :score)");
        $rq->bindValue(':sequence_photo', $partie->sequence_photo, PDO::PARAM_STR);
        $rq->bindValue(':score', $partie->score, PDO::PARAM_INT);
        $rq->execute();
    }

    public function updatePartie($partie)
    {
        // TODO: Implement updatePartie() method.
    }
}
