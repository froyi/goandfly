<?php declare(strict_types=1);

namespace Project\Module\Teaserbild;

use Project\Module\Database\Database;

/**
 * Class TeaserbildService
 * @package Project\Module\Teaserbild
 */
class TeaserbildService
{
    /** @var  TeaserbildFactory $teaserbildFactory */
    protected $teaserbildFactory;

    /** @var  TeaserbildRepository $teaserbildRepository */
    protected $teaserbildRepository;

    /**
     * TeaserbildService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->teaserbildFactory = new TeaserbildFactory();
        $this->teaserbildRepository = new TeaserbildRepository($database);
    }

    /**
     * @return array
     */
    public function getAllTeaserBilder(): array
    {
        $teaserbilderArray = [];

        $teaserbilder = $this->teaserbildRepository->getAllTeaserbilder();

        foreach ($teaserbilder as $teaserbildData) {
            $teaserbild = $this->teaserbildFactory->getTeaserbildFromObject($teaserbildData);
            $teaserbilderArray[$teaserbild->getTeaserbildId()->toString()] = $teaserbild;
        }

        return $teaserbilderArray;
    }
}