<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class RegionService
 * @package Project\Module\Region
 */
class RegionService
{
    /** @var RegionFactory $regionFactory */
    protected $regionFactory;

    /** @var RegionRepository $regionRepository */
    protected $regionRepository;

    /**
     * RegionService constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->regionFactory = new RegionFactory();
        $this->regionRepository = new RegionRepository($database);
    }

    /**
     * @return array
     */
    public function getAllRegions(): array
    {
        $regionsArray = [];

        $regions = $this->regionRepository->getAllRegions();

        foreach ($regions as $regionData) {
            $regionsArray[] = $this->regionFactory->getRegionFromObject($regionData);
        }

        return $regionsArray;
    }

    public function getAllRegionsByContinentId(Id $continentId): array
    {
        $regionsArray = [];

        $regions = $this->regionRepository->getAllRegionsByContinentId($continentId);

        foreach ($regions as $regionData) {
            $regionsArray[] = $this->regionFactory->getRegionFromObject($regionData);
        }

        return $regionsArray;

    }
}