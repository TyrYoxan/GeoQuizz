<?php

namespace api_geoquizz\infrastructure\repository;

use api_geoquizz\core\domain\entities\sequence\Sequence;
use api_geoquizz\core\dto\DTOSequence;
use api_geoquizz\core\repositoryInterfaces\RepositorySequenceInterface;
use PDO;

class RepositorySequence implements RepositorySequenceInterface
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllSequences(): array
    {
        $rq = $this->db->prepare("SELECT * FROM sequences");
        $rq->execute();
        return $rq->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSequence($id): Sequence
    {
        $rq = $this->db->prepare("SELECT * FROM sequences WHERE id_sequence = :id");
        $rq->bindValue(":id", $id);
        $rq->execute();
        $row = $rq->fetch();
        if (!$row) {
            throw new NotFoundSequenceException("Sequence with id " . $id. " not found");
        }
        return new Sequence($row['id_sequence'], $row['name'], $row['sequence'], $row['status']);
    }

    public function updateSequence($id): void
    {
        $rq = $this->db->prepare("UPDATE sequences SET status = true WHERE id_sequence = :id");
        $rq->bindValue(":id", $id);
        $rq->execute();
        if ($rq->rowCount() === 0) {
            throw new NotFoundSequenceException("Sequence with id " . $id. " not found");
        }

    }
}
