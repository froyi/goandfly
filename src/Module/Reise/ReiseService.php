<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Tag\TagService;

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

    public function getAllVisibleSortedCompleteReisen(TagService $tagService): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllVisibleSortedReisen();

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $tags = $tagService->getTagsByReiseId($reise->getReiseId());

            $reise->setTagListeToTagListe($tags);

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @return ReiseContainer
     */
    public function getAllReisenInContainer(TagService $tagService): ReiseContainer
    {
        return new ReiseContainer($this->getAllVisibleSortedCompleteReisen($tagService));
    }
}