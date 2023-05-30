<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * Class ID
 * @package Project\Module\GenericValueObject
 */
class Id
{
    /** @var Uuid $id */
    protected $id;

    /**
     * @return Id
     * @throws InvalidArgumentException
     */
    public static function generateId(): self
    {
        /** @var Uuid $uuId */
        $uuId = Uuid::uuid4();

        self::ensureValueIsValid($uuId);

        return new self($uuId);
    }

    /**
     * @param string $id
     * @return Id
     * @throws InvalidArgumentException
     */
    public static function fromString(string $id): self
    {
        self::ensureValueIsValid($id);

        return new self(Uuid::fromString($id));
    }

    /**
     * Id constructor.
     * @param $id
     */
    protected function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param $uuId
     * @throws InvalidArgumentException
     */
    protected static function ensureValueIsValid($uuId): void
    {
        if (Uuid::isValid(strval($uuId)) === false) {
            throw new InvalidArgumentException('This value is not valid $uuId');
        }
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $evalUuId
     * @return bool
     */
    public function eval(Uuid $evalUuId): bool
    {
        return ($evalUuId === $this->id);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->id;
    }
}