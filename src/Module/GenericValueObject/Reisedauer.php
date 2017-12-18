<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Reisedauer
 * @package Project\Module\GenericValueObject
 */
class Reisedauer
{
    protected const TRAVELDURATION_MIN = 1;

    /** @var int $reisedauer */
    protected $reisedauer;

    /**
     * Reisedauer constructor.
     * @param int $reisedauer
     */
    protected function __construct(int $reisedauer)
    {
        $this->reisedauer = $reisedauer;
    }

    /**
     * @param int $reisedauer
     * @return Reisedauer
     * @throws \InvalidArgumentException
     */
    public static function fromValue(int $reisedauer): self
    {
        self::ensureReisedauerIsValid($reisedauer);

        return new self($reisedauer);
    }

    /**
     * @param $reisedauer
     * @throws \InvalidArgumentException
     */
    protected static function ensureReisedauerIsValid($reisedauer): void
    {
        if ($reisedauer < self::TRAVELDURATION_MIN) {
            throw new \InvalidArgumentException('Die Reisedauer ist zu gering.', 1);
        }
    }

    /**
     * @return int
     */
    public function getReisedauer(): int
    {
        return $this->reisedauer;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->reisedauer;
    }
}
