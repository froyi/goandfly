<?php
declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\Database\Database;

/**
 * Class LeistungRepository
 * @package Project\Module\Leistung
 */
class LeistungRepository
{
    protected const TABLE = 'leistung';

    /** @var  Database $database */
    protected $database;

    /**
     * LeistungRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllLeistungen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}