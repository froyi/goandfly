<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class TerminService
 * @package Project\Module\Termin
 */
class TerminService
{
    /** @var TerminFactory $terminFactory */
    protected $terminFactory;

    /** @var TerminRepository $terminRepository */
    protected $terminRepository;

    /**
     * TerminService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->terminFactory = new TerminFactory();
        $this->terminRepository = new TerminRepository($database);
    }

    /**
     * @return array
     */
    public function getAllTermine(): array
    {
        $termineArray = [];

        $termine = $this->terminRepository->getAllTermine();

        foreach ($termine as $termineData) {
            $termin = $this->terminFactory->getTerminFromObject($termineData);
            $termineArray[$termin->getTerminId()->toString()] = $termin;
        }

        return $termineArray;
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getTermineByReiseId(Id $reiseId): array
    {
        $termineArray = [];

        $termine = $this->terminRepository->getTermineByReiseId($reiseId);

        foreach ($termine as $termineData) {
            $termin = $this->terminFactory->getTerminFromObject($termineData);
            $termineArray[$termin->getTerminId()->toString()] = $termin;
        }

        return $termineArray;
    }
}