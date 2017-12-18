<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class RegionRepository
 * @package Project\Module\Region
 */
class RegionRepository
{
    protected const TABLE = 'region';

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

        return $this->database->fetchAll($query);
    }

    public function getAllRegionsByContinentId(Id $continentId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('continentId', '=', $continentId->toString());

        return $this->database->fetchAll($query);
    }
}