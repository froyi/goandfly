<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

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
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllReiseverlauf(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getReiseverlaufByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());
        $query->orderBy('reisetag', Query::ASC);

        return $this->database->fetchAll($query);
    }
}