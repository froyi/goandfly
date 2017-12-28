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
            $region = $this->regionFactory->getRegionFromObject($regionData);
            $regionsArray[$region->getRegionId()->toString()] = $region;
        }

        return $regionsArray;
    }

    public function getAllRegionsByContinentId(Id $continentId): array
    {
        $regionsArray = [];

        $regions = $this->regionRepository->getAllRegionsByContinentId($continentId);

        foreach ($regions as $regionData) {
            $region = $this->regionFactory->getRegionFromObject($regionData);
            $regionsArray[$region->getRegionId()->toString()] = $region;
        }

        return $regionsArray;
    }

    /**
     * @param Id $reiseId
     *
     * @return null|Region
     */
    public function getRegionByReiseId(Id $reiseId): ?Region
    {
        $regionData = $this->regionRepository->getRegionByReiseId($reiseId);

        if ($regionData === false) {
            return null;
        }

        return $this->regionFactory->getRegionFromObject($regionData);
    }

    /**
     * @param Id|null $regionId
     */
    public function saveRegionToSession(Id $regionId = null): void
    {
        if ($regionId === null) {
            unset($_SESSION['regionId']);
        } else {
            $_SESSION['regionId'] = $regionId;
        }
    }
}