<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class ReiseverlaufService
 * @package Project\Module\Reiseverlauf
 */
class ReiseverlaufService
{
    /** @var  ReiseverlaufFactory $reiseverlaufFactory */
    protected $reiseverlaufFactory;

    /** @var  ReiseverlaufRepository $reiseverlaufRepository */
    protected $reiseverlaufRepository;

    /**
     * ReiseverlaufService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->reiseverlaufFactory = new ReiseverlaufFactory();
        $this->reiseverlaufRepository = new ReiseverlaufRepository($database);
    }

    /**
     * @return array
     */
    public function getAllReiseverlauf(): array
    {
        $reiseverlaufArray = [];

        $reiseverlaeufe = $this->reiseverlaufRepository->getAllReiseverlauf();

        foreach ($reiseverlaeufe as $reiseverlaufData) {
            $reiseverlauf = $this->reiseverlaufFactory->getReiseverlaufFromObject($reiseverlaufData);
            $reiseverlaufArray[$reiseverlauf->getReiseverlaufId()->toString()] = $reiseverlauf;
        }

        return $reiseverlaufArray;
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getReiseverlaufByReiseId(Id $reiseId): array
    {
        $reiseverlaufArray = [];

        $reiseverlaeufe = $this->reiseverlaufRepository->getReiseverlaufByReiseId($reiseId);

        foreach ($reiseverlaeufe as $reiseverlaufData) {
            $reiseverlauf = $this->reiseverlaufFactory->getReiseverlaufFromObject($reiseverlaufData);
            $reiseverlaufArray[$reiseverlauf->getReiseverlaufId()->toString()] = $reiseverlauf;
        }

        return $reiseverlaufArray;
    }
}