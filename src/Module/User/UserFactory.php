<?php declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\PasswordHash;

/**
 * Class UserFactory
 * @package Project\Module\User
 */
class UserFactory
{
    /**
     * @param $object
     *
     * @return User
     */
    public function getUserFromObject($object): User
    {
        /** @var Id $userId */
        $userId = Id::fromString($object->userId);

        /** @var Email $email */
        $email = Email::fromString($object->email);

        /** @var PasswordHash $passwordHash */
        $passwordHash = PasswordHash::fromString($object->passwordHash);

        return new User($userId, $email, $passwordHash);
    }
}