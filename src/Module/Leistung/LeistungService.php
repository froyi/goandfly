<?php declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class LeistungService
 * @package Project\Module\Leistung
 */
class LeistungService
{
    /** @var  LeistungFactory $leistungFactory */
    protected $leistungFactory;

    /** @var  LeistungRepository $leistungRepository */
    protected $leistungRepository;

    /**
     * LeistungService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->leistungFactory = new LeistungFactory();
        $this->leistungRepository = new LeistungRepository($database);
    }

    /**
     * @return array
     */
    public function getAllLeistungen(): array
    {
        $leistungenArray = [];

        $leistungen = $this->leistungRepository->getAllLeistungen();

        foreach ($leistungen as $leistungData) {
            $leistung = $this->leistungFactory->getLeistungFromObject($leistungData);
            $leistungenArray[$leistung->getLeistungId()->toString()] = $leistung;
        }

        return $leistungenArray;
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getLeistungenByReiseId(Id $reiseId): array
    {
        $leistungenArray = [];

        $leistungen = $this->leistungRepository->getLeistungenByReiseId($reiseId);

        foreach ($leistungen as $leistungData) {
            $leistung = $this->leistungFactory->getLeistungFromObject($leistungData);
            $leistungenArray[$leistung->getLeistungId()->toString()] = $leistung;
        }

        return $leistungenArray;
    }
}