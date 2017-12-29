<?php
declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\GenericValueObject\PasswordHash;

class UserFactory
{
    public function getLoggedInUserByPassword($object, Password $password): ?User
    {
        $userId = Id::fromString($object->userId);

        $email = Email::fromString($object->email);

        $passwordHash = PasswordHash::fromString($object->passwordHash);

        $user = new User($userId, $email, $passwordHash);

        if ($user->loginUser($password) === false) {
            return null;
        }

        return $user;
    }

    public function getLoggedInUserByUserId($object): ?User
    {
        $userId = Id::fromString($object->userId);

        $email = Email::fromString($object->email);

        $passwordHash = PasswordHash::fromString($object->passwordHash);

        $user = new User($userId, $email, $passwordHash);

        if ($user->loginUserBySession() === false) {
            return null;
        }

        return $user;
    }
}