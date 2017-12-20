<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\Database\Database;
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

    /**
     * ContinentService constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->continentFactory = new ContinentFactory();
        $this->continentRepository = new ContinentRepository($database);
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
     * @param RegionService $regionService
     * @return array
     */
    public function getAllContinentsWithRegionList(RegionService $regionService): array
    {
        $continentArray = [];

        $continents = $this->continentRepository->getAllContinents();

        foreach ($continents as $continentData) {
            $continent = $this->continentFactory->getContinentFromObject($continentData);

            $regions = $regionService->getAllRegionsByContinentId($continent->getContinentId());

            foreach ($regions as $region) {
                $continent->addRegionToRegionList($region);
            }

            $continentArray[$continent->getContinentId()->toString()] = $continent;
        }

        return $continentArray;
    }
}