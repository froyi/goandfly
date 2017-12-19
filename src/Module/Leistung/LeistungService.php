<?php declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\Database\Database;

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
            $leistungenArray[] = $this->leistungFactory->getLeistungFromObject($leistungData);
        }

        return $leistungenArray;
    }
}