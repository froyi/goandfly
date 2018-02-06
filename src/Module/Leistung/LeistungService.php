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
     * @return null|Leistung
     */
    public function getLeistungByReiseId(Id $reiseId): ?Leistung
    {
        $leistung = $this->leistungRepository->getLeistungByReiseId($reiseId);

        if (empty($leistung) || $leistung === false) {
            return null;
        }

        return $this->leistungFactory->getLeistungFromObject($leistung);
    }

    /**
     *
     *
     * @param array $parameter
     * @return null|Leistung
     */
    public function getLeistungByParams(array $parameter): ?Leistung
    {
        /** @var \stdClass $object */
        $object = (object)$parameter;

        if (empty($object->leistungId)) {
            $object->leistungId = Id::generateId()->toString();
        }

        if ($this->leistungFactory->isObjectValid($object) === true) {
            return $this->leistungFactory->getLeistungFromObject($object);
        }

        return null;
    }

    /**
     *
     *
     * @param Leistung $leistung
     * @return bool
     */
    public function saveLeistungToDatabase(Leistung $leistung): bool
    {
        return $this->leistungRepository->saveLeistung($leistung);
    }
}