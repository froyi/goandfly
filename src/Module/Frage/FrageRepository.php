<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\Database\Database;

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
}