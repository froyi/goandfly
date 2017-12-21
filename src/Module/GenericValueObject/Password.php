<?php
declare (strict_types=1);

namespace Project\Module\GenericValueObject;

/**
 * Class Password
 * @package Project\Module\GenericValueObject
 */
class Password
{
    /** @var string $password */
    protected $password;

    /**
     * Password constructor.
     * @param string $password
     */
    protected function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @param string $password
     * @return Password
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $password): self
    {
        self::ensurePasswordIsValid($password);

        return new self($password);
    }

    /**
     * @param string $password
     * @throws \InvalidArgumentException
     */
    protected static function ensurePasswordIsValid(string $password): void
    {
        if (strlen($password) < 5) {
            throw new \InvalidArgumentException('Dieser password ist zu kurz!', 1);
        }
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }
}

