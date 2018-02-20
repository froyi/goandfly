<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class RegionRepository
 * @package Project\Module\Region
 */
class RegionRepository
{
    protected const TABLE = 'region';

    protected const REISE_REGION_TABLE = 'reise_region';

    /** @var Database $database */
    protected $database;

    /**
     * RegionRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllRegions(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->orderBy('name', Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $continentId
     *
     * @return array
     */
    public function getAllRegionsByContinentId(Id $continentId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('continentId', '=', $continentId->toString());

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     */
    public function getRegionsByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::REISE_REGION_TABLE);
        $query->addTable(self::TABLE);
        $query->where(self::TABLE . '.regionId', '=', self::REISE_REGION_TABLE . '.regionId', true);
        $query->andWhere('reiseId', '=', $reiseId->toString());

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $regionId
     * @return mixed
     */
    public function getRegionByRegionId(Id $regionId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('regionId', '=', $regionId->toString());

        return $this->database->fetch($query);
    }
}