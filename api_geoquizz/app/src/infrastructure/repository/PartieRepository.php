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

    public function createPartie(InputPartieDTO $partie, String $id_user=null): void
    {
        $rq = $this->db->prepare("INSERT INTO parties
                             (sequence_photo, id_user, score) VALUES (:sequence_photo,:id_user, :score)");
        $rq->bindValue(':sequence_photo', $partie->sequence_photo, PDO::PARAM_STR);
        $rq->bindValue(':id_user', $id_user, PDO::PARAM_STR);
        $rq->bindValue(':score', $partie->score, PDO::PARAM_INT);
        $rq->execute();
    }

    public function updatePartie($partie)
    {
        // TODO: Implement updatePartie() method.
    }

    public function getUserParties(string $id): array
    {
        $rq = $this->db->prepare("SELECT id_partie, score 
                                    FROM parties
                                    WHERE id_user = :id");
        $rq->bindValue(':id', $id, PDO::PARAM_STR);
        $rq->execute();
        return $rq->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSequence(string $sequence, string $name): string
    {
        $rq = $this->db->prepare("INSERT INTO sequences
                             (sequence, name) VALUES (:sequence, :name) RETURNING id_sequence");
        $rq->bindValue(':sequence', $sequence, PDO::PARAM_STR);
        $rq->bindValue(':name', $name, PDO::PARAM_STR);
        $rq->execute();
        return $rq->fetchColumn();
    }
}
