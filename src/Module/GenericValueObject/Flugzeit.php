<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Flugzeit
 * @package Project\Module\GenericValueObject
 */
class Flugzeit
{
    protected const FLIGHT_MIN = 0;

    /** @var int $flugzeit */
    protected $flugzeit;

    /**
     * Flugzeit constructor.
     * @param int $flugzeit
     */
    protected function __construct(int $flugzeit)
    {
        $this->flugzeit = $flugzeit;
    }

    /**
     * @param int $flugzeit
     * @return Flugzeit
     * @throws \InvalidArgumentException
     */
    public static function fromValue(int $flugzeit): self
    {
        self::ensureFlugzeitIsValid($flugzeit);

        return new self($flugzeit);
    }

    /**
     * @param $flugzeit
     * @throws \InvalidArgumentException
     */
    protected static function ensureFlugzeitIsValid($flugzeit): void
    {
        if ($flugzeit < self::FLIGHT_MIN) {
            throw new \InvalidArgumentException('Die Flugzeit ist zu gering.', 1);
        }
    }

    /**
     * @return int
     */
    public function getFlugzeit(): int
    {
        return $this->flugzeit;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->flugzeit;
    }
}
