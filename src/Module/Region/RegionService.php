<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Reise\ReiseService;

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
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->regionFactory = new RegionFactory();
        $this->regionRepository = new RegionRepository($database);
    }

    /**
     * @param Id $continentId
     * @return array
     */
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
    public function getRegionsByReiseId(Id $reiseId): array
    {
        $regionsArray = [];
        $regions = $this->regionRepository->getRegionsByReiseId($reiseId);

        foreach ($regions as $regionData) {
            $region = $this->regionFactory->getRegionFromObject($regionData);
            $regionsArray[$region->getRegionId()->toString()] = $region;
        }

        return $regionsArray;
    }

    /**
     * @param Id|null $regionId
     */
    public function saveRegionToSession(Id $regionId = null): void
    {
        if ($regionId === null) {
            unset($_SESSION['regionId']);
        } else {
            $_SESSION['regionId'] = $regionId->toString();
        }
    }

    /**
     * @param ReiseService $reiseService
     *
     * @return array
     */
    public function getAllRegionsWithReisen(ReiseService $reiseService, ?bool $backend = false): array
    {
        $regionArray = [];

        $regions = $this->getAllRegions();

        /** @var Region $region */
        foreach ($regions as $region) {
            $reisen = $reiseService->getAllReisenByRegionId($region->getRegionId(), $backend);

            $region->setReisenList($reisen);

            $regionArray[$region->getRegionId()->toString()] = $region;
        }

        return $regionArray;
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

    /**
     * @param Id $regionId
     * @return null|Region
     */
    public function getRegionByRegionId(Id $regionId): ?Region
    {
        $regionData = $this->regionRepository->getRegionByRegionId($regionId);

        if (empty($regionData)) {
            return null;
        }

        return $this->regionFactory->getRegionFromObject($regionData);
    }
}