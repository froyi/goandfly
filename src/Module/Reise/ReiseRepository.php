<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Database\Query;

/**
 * Class ReiseRepository
 * @package Project\Module\Reise
 */
class ReiseRepository
{
    protected const TABLE = 'reise';

    /** @var Database $database */
    protected $database;

    /**
     * ReiseRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllReisen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @return array
     */
    public function getAllVisibleReisen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('sichtbar', '>=', date('Y-m-d'));

        return $this->database->fetchAll($query);
    }

    public function getAllVisibleSortedReisen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('sichtbar', '>=', date('Y-m-d'));
        $query->orderBy('bearbeitet', Query::DESC);

        return $this->database->fetchAll($query);
    }
}