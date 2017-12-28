<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Frage\FrageService;
use Project\Module\GenericValueObject\Id;
use Project\Module\Leistung\LeistungService;
use Project\Module\Region\RegionService;
use Project\Module\Reiseverlauf\ReiseverlaufService;
use Project\Module\Tag\TagService;
use Project\Module\Termin\TerminService;

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

    /** @var  TerminService $terminService */
    protected $terminService;

    /** @var  ReiseverlaufService $reiseverlaufService */
    protected $reiseverlaufService;

    /** @var  LeistungService $leistungService */
    protected $leistungService;

    /** @var  FrageService $frageService */
    protected $frageService;

    /** @var  TagService */
    protected $tagService;

    /** @var  RegionService $regionService */
    protected $regionService;

    /**
     * ReiseService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->reiseFactory = new ReiseFactory();
        $this->reiseRepository = new ReiseRepository($database);

        $this->terminService = new TerminService($database);
        $this->reiseverlaufService = new ReiseverlaufService($database);
        $this->leistungService = new LeistungService($database);
        $this->frageService = new FrageService($database);
        $this->tagService = new TagService($database);
        $this->regionService = new RegionService($database);
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

            $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

            if ($region !== null) {
                $reise->setRegion($region);
            }

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

            $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

            if ($region !== null) {
                $reise->setRegion($region);
            }

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @param int|null $amount
     *
     * @return ReiseContainer
     */
    public function getAllReisenInContainer(int $amount = null): ReiseContainer
    {
        return new ReiseContainer($this->getAllVisibleSortedCompleteReisen($amount));
    }

    /**
     * @param int|null $amount
     *
     * @return array
     */
    public function getAllVisibleSortedCompleteReisen(int $amount = null): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllVisibleSortedReisen($amount);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

            if ($region !== null) {
                $reise->setRegion($region);
            }

            $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

            $reise->setTagListeToTagListe($tags);

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @param int|null $amount
     *
     * @return ReiseContainer
     */
    public function getAllShuffledReisenInContainer(int $amount = null): ReiseContainer
    {
        $reisen = $this->getAllVisibleSortedCompleteReisen($amount);

        shuffle($reisen);

        return new ReiseContainer($reisen);
    }

    /**
     * @param Id $reiseId
     *
     * @return Reise
     */
    public function getCompleteReiseByReiseId(Id $reiseId): ?Reise
    {
        $reiseData = $this->reiseRepository->getReiseByReiseId($reiseId);

        if ($reiseData === false) {
            return null;
        }

        /** @var Reise $reise */
        $reise = $this->reiseFactory->getReiseFromObject($reiseData);

        // Region
        $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

        if ($region !== null) {
            $reise->setRegion($region);
        }

        // Termine
        $termine = $this->terminService->getTermineByReiseId($reise->getReiseId());

        if (count($termine) > 0) {
            $reise->setTerminListe($termine);
        }

        // Reiseverlauf
        $reiseverlauf = $this->reiseverlaufService->getReiseverlaufByReiseId($reise->getReiseId());

        if (count($reiseverlauf) > 0) {
            $reise->setReiseverlaufListe($reiseverlauf);
        }

        // Leistungen
        $leistungen = $this->leistungService->getLeistungenByReiseId($reise->getReiseId());

        if (count($leistungen) > 0) {
            $reise->setLeistungListe($leistungen);
        }

        // Fragen
        $fragen = $this->frageService->getFragenByReiseId($reise->getReiseId());

        if (count($fragen) > 0) {
            $reise->setFrageListe($fragen);
        }

        return $reise;
    }

    /**
     * @param Id $regionId
     * @param int|null $amount
     *
     * @return array
     */
    public function getReiseRecommenderByRegionId(Id $regionId, int $amount = null): array
    {
        $reiseRecommender = [];

        $reisen = $this->reiseRepository->getAllVisibleReisenByRegionId($regionId, $amount);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

            if ($region !== null) {
                $reise->setRegion($region);
            }

            $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

            $reise->setTagListeToTagListe($tags);

            $reiseRecommender[$reise->getReiseId()->toString()] = $reise;
        }

        return $reiseRecommender;
    }

    public function getAllTagAndRegionReisenInContainer(array $tags = [], Id $regionId = null, int $amount = null): ReiseContainer
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getReiseByTagsAndRegionId($tags, $regionId, $amount);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $region = $this->regionService->getRegionByReiseId($reise->getReiseId());

            if ($region !== null) {
                $reise->setRegion($region);
            }

            $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

            $reise->setTagListeToTagListe($tags);

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return new ReiseContainer($reisenArray);
    }
}