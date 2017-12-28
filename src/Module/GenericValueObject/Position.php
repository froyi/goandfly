<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Position
 * @package Project\Module\GenericValueObject
 */
class Position
{
    protected const POSITION_MIN = 1;

    /** @var int $position */
    protected $position;

    /**
     * Position constructor.
     *
     * @param int $position
     */
    protected function __construct(int $position)
    {
        $this->position = $position;
    }

    /**
     * @param int $position
     *
     * @return Position
     * @throws \InvalidArgumentException
     */
    public static function fromValue(int $position): self
    {
        self::ensurePositionIsValid($position);

        return new self($position);
    }

    /**
     * @param $position
     *
     * @throws \InvalidArgumentException
     */
    protected static function ensurePositionIsValid($position): void
    {
        if ($position < self::POSITION_MIN) {
            throw new \InvalidArgumentException('Die Position ist zu gering.', 1);
        }
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->position;
    }
}
