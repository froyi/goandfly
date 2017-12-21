<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\Database\Database;

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
}