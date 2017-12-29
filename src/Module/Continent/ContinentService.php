<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Region\RegionService;

/**
 * Class ContinentService
 * @package Project\Module\Continent
 */
class ContinentService
{
    /** @var ContinentFactory */
    protected $continentFactory;

    /** @var ContinentRepository */
    protected $continentRepository;

    /** @var  RegionService $regionService */
    protected $regionService;

    /**
     * ContinentService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->continentFactory = new ContinentFactory();
        $this->continentRepository = new ContinentRepository($database);

        $this->regionService = new RegionService($database);
    }

    /**
     * @return array
     */
    public function getAllContinents(): array
    {
        $continentArray = [];

        $continents = $this->continentRepository->getAllContinents();

        foreach ($continents as $continentData) {
            $continent = $this->continentFactory->getContinentFromObject($continentData);
            $continentArray[$continent->getContinentId()->toString()] = $continent;
        }

        return $continentArray;
    }

    /**
     * @return array
     */
    public function getAllContinentsWithRegionList(): array
    {
        $continentArray = [];

        $continents = $this->continentRepository->getAllContinents();

        foreach ($continents as $continentData) {
            $continent = $this->continentFactory->getContinentFromObject($continentData);

            $regions = $this->regionService->getAllRegionsByContinentId($continent->getContinentId());

            foreach ($regions as $region) {
                $continent->addRegionToRegionList($region);
            }

            $continentArray[$continent->getContinentId()->toString()] = $continent;
        }

        return $continentArray;
    }

    /**
     * @param Id $continentId
     *
     * @return null|Continent
     */
    public function getContinentByContinentId(Id $continentId): ?Continent
    {
        $continentData = $this->continentRepository->getContinentByContinentId($continentId);

        if ($continentData === false) {
            return null;
        }

        $continent = $this->continentFactory->getContinentFromObject($continentData);

        $regions = $this->regionService->getAllRegionsByContinentId($continent->getContinentId());

        foreach ($regions as $region) {
            $continent->addRegionToRegionList($region);
        }

        return $continent;
    }
}