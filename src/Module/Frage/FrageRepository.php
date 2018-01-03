<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class FrageRepository
 * @package Project\Module\Frage
 */
class FrageRepository
{
    protected const TABLE = 'frage';

    /** @var Database $database */
    protected $database;

    /**
     * FrageRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllFragen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getFragenByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->fetchAll($query);
    }

    /**
     * @param Frage $frage
     *
     * @return bool
     */
    public function saveFrageToDatabase(Frage $frage): bool
    {
        if (!empty($this->getFrageByFrageId($frage->getFrageId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('frageId', $frage->getFrageId()->toString());
            $query->set('reiseId', $frage->getReiseId()->toString());
            $query->set('frage', $frage->getFrage()->getText());
            $query->set('antwort', $frage->getAntwort()->getText());

            $query->where('frageId', '=', $frage->getReiseId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('frageId', $frage->getFrageId()->toString());
        $query->insert('reiseId', $frage->getReiseId()->toString());
        $query->insert('frage', $frage->getFrage()->getText());
        $query->insert('antwort', $frage->getAntwort()->getText());

        return $this->database->execute($query);
    }

    /**
     * @param Id $frageId
     *
     * @return mixed
     */
    public function getFrageByFrageId(Id $frageId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('frageId', '=', $frageId->toString());

        return $this->database->fetch($query);
    }
}