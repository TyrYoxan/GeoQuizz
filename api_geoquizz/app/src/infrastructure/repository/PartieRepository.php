<?php

namespace api_geoquizz\infrastructure\repository;

use api_auth\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use api_geoquizz\core\domain\entities\sequence\Sequence;
use api_geoquizz\core\dto\InputPartieDTO;
use api_geoquizz\core\repositoryInterfaces\RepositoryPartieInterface;
use api_geoquizz\core\domain\entities\partie\Partie;
use PDO;
use PDOException;

class PartieRepository implements RepositoryPartieInterface
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getPartie($id): Partie
    {
        $data = $this->db->prepare("SELECT sequence_photo, name, sequence, status, score
                             FROM parties
                             INNER JOIN sequences ON parties.sequence_photo = sequences.id_sequence
                             WHERE id_partie = :id");
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        $row = $data->fetch();

        if(!$row) {
          throw new NotFoundPartieException("Partie with id " . $id . " not found");
        }

        $sequence = new Sequence($row['sequence_photo'], $row['name'],$row['sequence'], $row['status'], $row['score']);
        return new Partie($sequence, $row['score']);
    }

    public function createPartie(InputPartieDTO $partie, String $id_user = null): String
    {
        try {
            $rq = $this->db->prepare("INSERT INTO parties
                             (sequence_photo, id_user, score) VALUES (:sequence_photo, :id_user, :score) RETURNING id_partie");

            $rq->bindValue(':sequence_photo', $partie->sequence_photo, PDO::PARAM_STR);
            $rq->bindValue(':id_user', $id_user ?? null, PDO::PARAM_STR);
            $rq->bindValue(':score', $partie->score, PDO::PARAM_INT);
            $rq->execute();

            return $rq->fetchColumn();
        }catch (PDOException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }

    }

    public function updatePartie($partie): void
    {
        $rq = $this->db->prepare("UPDATE parties SET score=:score WHERE sequence_photo=:sequence");
        $rq->bindValue(':score', $partie->score, PDO::PARAM_INT);
        $rq->bindValue(':sequence', $partie->sequence_photo, PDO::PARAM_STR);
        $rq->execute();
    }

    public function getUserParties(string $id): array
    {
        $rq = $this->db->prepare("SELECT sequence_photo, name, status, score
                             FROM parties
                             INNER JOIN sequences ON parties.sequence_photo = sequences.id_sequence
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
