<?php
declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\GenericValueObject\PasswordHash;

class User
{
    /** @var  Id $userId */
    protected $userId;

    /** @var  Email $email */
    protected $email;

    /** @var  PasswordHash $passwordHash */
    protected $passwordHash;

    /** @var  bool $isLoggedIn */
    protected $isLoggedIn;

    public function __construct(Id $userId, Email $email, PasswordHash $passwordHash)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->isLoggedIn = false;
    }

    /**
     * @return Id
     */
    public function getUserId(): Id
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Password $password
     * @return bool
     */
    public function loginUser(Password $password): bool
    {
        if ($this->passwordHash->verifyPassword($password) === true) {
            $this->loginSuccessUser();

            return true;
        }

        $this->logoutUser();

        return false;
    }

    /**
     * @return bool
     */
    public function loginUserBySession(): bool
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId'] === $this->userId->toString()) {
            $this->loginSuccessUser();

            return true;
        }

        $this->logoutUser();

        return false;
    }

    public function logout(): bool
    {
        return $this->logoutUser();
    }

    /**
     *
     */
    protected function loginSuccessUser(): void
    {
        $this->isLoggedIn = true;
        $_SESSION['userId'] = $this->userId->toString();
    }

    protected function logoutUser(): bool
    {
        $this->isLoggedIn = false;

        if (isset($_SESSION)) {
            unset($_SESSION['userId']);
        }

        return true;
    }
}