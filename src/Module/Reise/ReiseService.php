<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Frage\FrageService;
use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\Id;
use Project\Module\Leistung\Leistung;
use Project\Module\Leistung\LeistungService;
use Project\Module\Region\Region;
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

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
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

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
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

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
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

        $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

        if (count($regions) > 0) {
            $reise->setRegionList($regions);
        }

        // Termine
        $termine = $this->terminService->getTermineByReiseId($reise->getReiseId());

        if (\count($termine) > 0) {
            $reise->setTerminListe($termine);
        }

        // Reiseverlauf
        $reiseverlauf = $this->reiseverlaufService->getReiseverlaufByReiseId($reise->getReiseId());

        if (\count($reiseverlauf) > 0) {
            $reise->setReiseverlaufListe($reiseverlauf);
        }

        // Leistungen
        $leistung = $this->leistungService->getLeistungByReiseId($reise->getReiseId());

        if ($leistung instanceof Leistung) {
            $reise->setLeistung($leistung);
        }

        $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

        $reise->setTagListeToTagListe($tags);

        // Fragen
        $fragen = $this->frageService->getFragenByReiseId($reise->getReiseId());

        if (\count($fragen) > 0) {
            $reise->setFrageListe($fragen);
        }

        return $reise;
    }

    /**
     * @param Reise    $reiseVergleich
     * @param int|null $amount
     *
     * @return array
     */
    public function getReiseRecommenderByReise(Reise $reiseVergleich, int $amount = null): array
    {
        $reiseRecommender = [];

        if (count($reiseVergleich->getRegionList()) > 0) {
            $regions = $reiseVergleich->getRegionList();
            $firstRegion = reset($regions);
            $reisen = $this->reiseRepository->getAllVisibleReisenByRegionId($firstRegion->getRegionId());

            shuffle($reisen);

            foreach ($reisen as $reiseData) {
                $reise = $this->reiseFactory->getReiseFromObject($reiseData);

                if ($reise->getReiseId()->toString() === $reiseVergleich->getReiseId()->toString()) {
                    continue;
                }

                $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

                if (count($regions) > 0) {
                    $reise->setRegionList($regions);
                }

                $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

                $reise->setTagListeToTagListe($tags);

                $reiseRecommender[$reise->getReiseId()->toString()] = $reise;

                if (\count($reiseRecommender) >= $amount) {
                    break;
                }
            }
        }

        return $reiseRecommender;
    }

    /**
     * @param array    $tags
     * @param Id|null  $regionId
     * @param int|null $amount
     *
     * @return ReiseContainer
     */
    public function getAllTagAndRegionReisenInContainer(
        array $tags = [], Id $regionId = null, int $amount = null
    ): ReiseContainer {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getReiseByTagsAndRegionId($tags, $regionId, $amount);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
            }

            $tags = $this->tagService->getTagsByReiseId($reise->getReiseId());

            $reise->setTagListeToTagListe($tags);

            $reisenArray[$reise->getReiseId()->toString()] = $reise;

            if ($amount !== null && count($reisenArray) >= $amount) {
                break;
            }
        }

        return new ReiseContainer($reisenArray);
    }

    /**
     * @param Id $regionId
     *
     * @return array
     */
    public function getAllReisenByRegionId(Id $regionId): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllReisenByRegionId($regionId);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @return array
     */
    public function getVeranstalterWithReisen(): array
    {
        $veranstalterArray = [];

        $veranstalterListe = $this->reiseRepository->getAllVeranstalter();

        foreach ($veranstalterListe as $veranstalterData) {
            /** @var Reiseveranstalter $veranstalter */
            $veranstalter = $this->reiseFactory->getVeranstalterFromObject($veranstalterData);

            $reisen = $this->getAllReisenByVeranstalter($veranstalter);

            $veranstalter->setReiseList($reisen);

            $veranstalterArray[] = $veranstalter;
        }

        return $veranstalterArray;
    }

    /**
     * @param Reiseveranstalter $reiseveranstalter
     *
     * @return array
     */
    public function getAllReisenByVeranstalter(Reiseveranstalter $reiseveranstalter): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllReisenByVeranstalter($reiseveranstalter);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
            }

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @param Id $tagId
     *
     * @return array
     */
    public function getAllReisenByTagId(Id $tagId): array
    {
        $reisenArray = [];

        $reisen = $this->reiseRepository->getAllReisenByTagId($tagId);

        foreach ($reisen as $reiseData) {
            $reise = $this->reiseFactory->getReiseFromObject($reiseData);

            $regions = $this->regionService->getRegionsByReiseId($reise->getReiseId());

            if (count($regions) > 0) {
                $reise->setRegionList($regions);
            }

            $reisenArray[$reise->getReiseId()->toString()] = $reise;
        }

        return $reisenArray;
    }

    /**
     * @param array $parameter
     *
     * @return Reise
     */
    public function getReiseByParams(array $parameter, RegionService $regionService): Reise
    {
        if (empty($parameter['reiseId'])) {
            $parameter['reiseId'] = Id::generateId()->toString();
        }

        if (empty($parameter['bearbeitet'])) {
            $parameter['bearbeitet'] = Datetime::fromValue('now')->toString();
        }

        $reise = $this->reiseFactory->getReiseFromUploadedData($parameter);

        foreach ($parameter['region'] as $regionIdData) {
            $regionId = Id::fromString($regionIdData);

            $region = $regionService->getRegionByRegionId($regionId);

            $reise->addRegionToRegionList($region);
        }

        return $reise;
    }

    /**
     * @param Reise $reise
     *
     * @return bool
     */
    public function saveReiseToDatabase(Reise $reise): bool
    {
        if ($this->reiseRepository->saveReiseToDatabase($reise)) {
            /** @var Region $region */
            foreach ($reise->getRegionList() as $region) {
                $this->reiseRepository->saveReiseRegionToDatabase($reise, $region);
            }

            return true;
        }

        return false;
    }

    /**
     *
     *
     * @param Id $reiseId
     * @return bool
     */
    public function deleteReiseByReiseId(Id $reiseId): bool
    {
        $reise = $this->getCompleteReiseByReiseId($reiseId);

        if ($reise === null) {
            return false;
        }

        return $this->reiseRepository->deleteReise($reise);
    }
}