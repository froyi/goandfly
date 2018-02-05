<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class FrageService
 * @package Project\Module\Frage
 */
class FrageService
{
    /** @var FrageFactory $frageFactory */
    protected $frageFactory;

    /** @var FrageRepository $frageRepository */
    protected $frageRepository;

    /**
     * FrageService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->frageFactory = new FrageFactory();
        $this->frageRepository = new FrageRepository($database);
    }

    /**
     * @return array
     */
    public function getAllFragen(): array
    {
        $fragenArray = [];

        $fragen = $this->frageRepository->getAllFragen();

        foreach ($fragen as $fragenData) {
            $frage = $this->frageFactory->getFrageFromObject($fragenData);
            $fragenArray[$frage->getFrageId()->toString()] = $frage;
        }

        return $fragenArray;
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getFragenByReiseId(Id $reiseId): array
    {
        $fragenArray = [];

        $fragen = $this->frageRepository->getFragenByReiseId($reiseId);

        foreach ($fragen as $fragenData) {
            $frage = $this->frageFactory->getFrageFromObject($fragenData);
            $fragenArray[$frage->getFrageId()->toString()] = $frage;
        }

        return $fragenArray;
    }

    /**
     *
     *
     * @param Id $frageId
     * @return null|Frage
     */
    public function getFrageByFrageId(Id $frageId): ?Frage
    {
        $frageData = $this->frageRepository->getFrageByFrageId($frageId);

        if ($frageData === false) {
            return null;
        }

        return $this->frageFactory->getFrageFromObject($frageData);
    }

    /**
     * @param array $parameter
     *
     * @return null|Frage
     */
    public function getFrageByParams(array $parameter): ?Frage
    {
        /** @var \stdClass $object */
        $object = (object)$parameter;

        if (empty($object->frageId)) {
            $object->frageId = Id::generateId()->toString();
        }

        if ($this->frageFactory->isObjectValid($object) === true) {
            return $this->frageFactory->getFrageFromObject($object);
        }

        return null;
    }

    /**
     * @param Frage $frage
     *
     * @return bool
     */
    public function saveFrageToDatabase(Frage $frage): bool
    {
        return $this->frageRepository->saveFrageToDatabase($frage);
    }
}