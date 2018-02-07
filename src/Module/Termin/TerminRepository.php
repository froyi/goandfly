<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class TerminRepository
 * @package Project\Module\Termin
 */
class TerminRepository
{
    protected const TABLE = 'termin';

    /** @var  Database $database */
    protected $database;

    /**
     * TerminRepository constructor.
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
    public function getAllTermine(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getTermineByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());
        $query->orderBy('start', Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     *
     *
     * @param Id $terminId
     * @return mixed
     */
    public function getTerminByTerminId(Id $terminId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('terminId', '=', $terminId->toString());

        return $this->database->fetch($query);
    }

    /**
     *
     *
     * @param Termin $termin
     * @return bool
     */
    public function saveTerminToDatabase(Termin $termin): bool
    {
        if (!empty($this->getTerminByTerminId($termin->getTerminId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('terminId', $termin->getTerminId()->toString());
            $query->set('reiseId', $termin->getReiseId()->toString());
            $query->set('start', $termin->getStart()->toString());
            $query->set('ende', $termin->getEnde()->toString());
            $query->set('preis', $termin->getPreis()->getText());

            $query->where('terminId', '=', $termin->getTerminId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('terminId', $termin->getTerminId()->toString());
        $query->insert('reiseId', $termin->getReiseId()->toString());
        $query->insert('start', $termin->getStart()->toString());
        $query->insert('ende', $termin->getEnde()->toString());
        $query->insert('preis', $termin->getPreis()->getText());

        return $this->database->execute($query);
    }

    /**
     *
     *
     * @param Id $terminId
     * @return bool
     */
    public function deleteTerminByTerminId(Id $terminId): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('terminId', '=', $terminId->toString());

        return $this->database->execute($query);
    }
}