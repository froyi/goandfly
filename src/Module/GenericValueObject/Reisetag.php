<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Reisetag
 * @package Project\Module\GenericValueObject
 */
class Reisetag
{
    protected const DAY_MIN = 1;

    /** @var int $reisetag */
    protected $reisetag;

    /**
     * Reisetag constructor.
     * @param int $reisetag
     */
    protected function __construct(int $reisetag)
    {
        $this->reisetag = $reisetag;
    }

    /**
     * @param int $reisetag
     * @return Reisetag
     * @throws \InvalidArgumentException
     */
    public static function fromValue(int $reisetag): self
    {
        self::ensureReisetagIsValid($reisetag);

        return new self($reisetag);
    }

    /**
     * @param $reisetag
     * @throws \InvalidArgumentException
     */
    protected static function ensureReisetagIsValid($reisetag): void
    {
        if ($reisetag < self::DAY_MIN) {
            throw new \InvalidArgumentException('Der Reisetag ist zu gering.', 1);
        }
    }

    /**
     * @return int
     */
    public function getReisetag(): int
    {
        return $this->reisetag;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->reisetag;
    }
}
