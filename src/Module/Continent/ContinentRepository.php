<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\Database\Database;

/**
 * Class ContinentRepository
 * @package Project\Module\Continent
 */
class ContinentRepository
{
    protected const TABLE = 'continent';
    /** @var Database $database */
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAllContinents(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}