<?php
declare (strict_types=1);

namespace Project\Module\Reise;

/**
 * Class ReiseContainer
 * @package Project\Module\Reise
 */
class ReiseContainer
{
    protected const REISE_TEASER_COUNT = 3;

    /** @var array $reiseListe */
    protected $reiseListe = [];

    /** @var array $teaserReiseListe */
    protected $teaserReiseListe = [];

    /**
     * @return array
     */
    public function getTeaserReiseListe(): array
    {
        return $this->teaserReiseListe;
    }

    /**
     * @return array
     */
    public function getBottomReiseListe(): array
    {
        return $this->bottomReiseListe;
    }

    /** @var array $bottomReiseListe */
    protected $bottomReiseListe = [];

    /**
     * @return array
     */
    public function getReiseListe(): array
    {
        return $this->reiseListe;
    }

    /**
     * ReiseContainer constructor.
     * @param array $reiseListe
     */
    public function __construct(array $reiseListe)
    {
        $this->reiseListe = $reiseListe;

        $this->generateReiseListen();
    }

    /**
     *
     */
    protected function generateReiseListen(): void
    {
        /** @var Reise $reise */
        foreach ($this->reiseListe as $reise) {
            if (count($this->teaserReiseListe) < self::REISE_TEASER_COUNT) {
                $this->teaserReiseListe[$reise->getReiseId()->toString()] = $reise;
            } else {
                $this->bottomReiseListe[$reise->getReiseId()->toString()] = $reise;
            }
        }
    }

    /**
     * @param Reise $reise
     */
    public function addReiseToReiseList(Reise $reise): void
    {
        $this->reiseListe[] = $reise;
    }

    /**
     *
     */
    public function resetReiseListe(): void
    {
        $this->reiseListe = [];
    }
}