<?php declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\PasswordHash;

/**
 * Class User
 * @package Project\Module\User
 */
class User
{
    /** @var  Id $userId */
    protected $userId;

    /** @var  Email $email */
    protected $email;

    /** @var PasswordHash $passwordHash */
    protected $passwordHash;

    /**
     * User constructor.
     *
     * @param Id $userId
     * @param Email $email
     * @param PasswordHash $passwordHash
     */
    public function __construct(Id $userId, Email $email, PasswordHash $passwordHash)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    /**
     * @param PasswordHash $passwordHash
     */
    public function setPasswordHash(PasswordHash $passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return Id
     */
    public function getUserId(): Id
    {
        return $this->userId;
    }

}