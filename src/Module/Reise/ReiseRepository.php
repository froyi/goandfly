<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class ReiseRepository
 * @package Project\Module\Reise
 */
class ReiseRepository
{
    protected const TABLE = 'reise';

    protected const REISE_REGION_TABLE = 'reise_region';

    /** @var Database $database */
    protected $database;

    /**
     * ReiseRepository constructor.
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

    /**
     * @param Id $reiseId
     *
     * @return mixed
     */
    public function getReiseByReiseId(Id $reiseId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param int|null $amount
     *
     * @return array
     */
    public function getAllVisibleSortedReisen(int $amount = null): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('sichtbar', '>=', date('Y-m-d'));
        $query->orderBy('bearbeitet', Query::DESC);

        if ($amount !== null) {
            $query->limit($amount);
        }

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $regionId
     * @param int|null $amount
     *
     * @return array
     */
    public function getAllVisibleReisenByRegionId(Id $regionId, int $amount = null): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        $query->addTable(self::REISE_REGION_TABLE);

        $query->where('sichtbar', '>=', date('Y-m-d'));
        $query->andWhere('regionId', '=', $regionId->toString());
        $query->andWhere(self::TABLE . '.reiseId', '=', self::REISE_REGION_TABLE . '.reiseId', true);
        $query->orderBy('bearbeitet', Query::DESC);

        if ($amount !== null) {
            $query->limit($amount);
        }

        return $this->database->fetchAll($query);
    }
}