<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Terrain
 * @package Project\Module\GenericValueObject
 */
class Terrain
{
    protected const TERRAIN_MIN = 1;
    protected const TERRAIN_MAX = 5;

    /** @var int $terrain */
    protected $terrain;

    /**
     * Terrain constructor.
     * @param int $terrain
     */
    protected function __construct(int $terrain)
    {
        $this->terrain = $terrain;
    }

    /**
     * @param int $terrain
     * @return Terrain
     * @throws \InvalidArgumentException
     */
    public static function fromValue(int $terrain): self
    {
        self::ensureTerrainIsValid($terrain);

        return new self($terrain);
    }

    /**
     * @param int $terrain
     * @throws \InvalidArgumentException
     */
    protected static function ensureTerrainIsValid(int $terrain): void
    {
        if ($terrain < self::TERRAIN_MIN) {
            throw new \InvalidArgumentException('Die Terrainwertung ist zu gering.', 1);
        }

        if ($terrain > self::TERRAIN_MAX) {
            throw new \InvalidArgumentException('Die Terrainwertung ist zu groß.', 1);
        }
    }

    /**
     * @return int
     */
    public function getTerrain(): int
    {
        return $this->terrain;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->terrain;
    }
}
