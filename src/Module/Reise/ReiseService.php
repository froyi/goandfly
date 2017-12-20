<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;

/**
 * Class ReiseService
 * @package Project\Module\Reise
 */
class ReiseService
{
    /** @var ReiseFactory $reiseFactory */
    protected $reiseFactory;

    /** @var ReiseRepository $reiseRepository */
    protected $reiseRepository;

    /**
     * ReiseService constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->reiseFactory = new ReiseFactory();
        $this->reiseRepository = new ReiseRepository($database);
    }

    /**
     * @return array
     */
    public function getAllReisen(): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllReisen();

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);
            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @return array
     */
    public function getAllVisibleReisen(): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllVisibleReisen();

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);
            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }
}