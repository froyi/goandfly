<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Personen
 * @package Project\Module\GenericValueObject
 */
class Personen
{
    /** @var array $personen */
    protected $personen = [];

    /** @var bool $isFix */
    protected $isFix = false;


    /**
     * Name constructor.
     * @param string $name
     */
    protected function __construct(array $personen)
    {
        $this->personen['min'] = $personen[0];
        $this->personen['max'] = $personen[1];

        if ($this->personen['min'] === $this->personen['max']) {
            $this->isFix = true;
        }
    }

    /**
     * @param $personen
     * @return Personen
     * @throws \InvalidArgumentException
     */
    public static function fromValue($personen): self
    {
        self::ensurePersonenIsValid($personen);
        $personen = self::convertPersonen($personen);

        return new self($personen);
    }

    /**
     * @param string $personen
     * @throws \InvalidArgumentException
     */
    protected static function ensurePersonenIsValid($personen): void
    {
        if (empty($personen)) {
            throw new \InvalidArgumentException('Keine Personen vorhanden.', 1);
        }
    }

    /**
     * @param $personen
     * @return array
     */
    protected static function convertPersonen($personen): array
    {
        $personenArray = [];

        if (\is_int($personen)) {
            $personenArray[0] = $personen;
            $personenArray[1] = $personen;

            return $personenArray;
        }

        $personenData = explode('-', $personen);

        $personenArray[0] = (int)$personenData[0];

        if (isset($personenData[1])) {
            $personenArray[1] = (int)$personenData[1];
        } else {
            $personenArray[1] = (int)$personenData[0];
        }

        return $personenArray;
    }

    /**
     * @return string
     */
    public function getPersonen(): string
    {
        if ($this->isFix === true) {
            return (string)$this->personen['min'];
        }

        return $this->personen['min'] . '-' . $this->personen['max'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPersonen();
    }
}

