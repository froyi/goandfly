<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\Database\Database;

/**
 * Class ReiseverlaufRepository
 * @package Project\Module\Reiseverlauf
 */
class ReiseverlaufRepository
{
    protected const TABLE = 'reiseverlauf';

    /** @var  Database $database */
    protected $database;

    /**
     * ReiseverlaufRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database;
    }

    /**
     * @return array
     */
    public function getAllReiseverlauf(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}