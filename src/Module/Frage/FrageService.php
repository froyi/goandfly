<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\Database\Database;

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
}