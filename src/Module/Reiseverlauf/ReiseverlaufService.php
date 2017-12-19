<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\Database\Database;

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
            $reiseverlaufArray[] = $this->reiseverlaufFactory->getReiseverlaufFromObject($reiseverlaufData);
        }

        return $reiseverlaufArray;
    }
}