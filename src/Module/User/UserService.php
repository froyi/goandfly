<?php declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\Database\Database;

/**
 * Class UserService
 * @package Project\Module\User
 */
class UserService
{
    /** @var  UserFactory $userFactory */
    protected $userFactory;

    /** @var  UserRepository $userRepository */
    protected $userRepository;

    /**
     * UserService constructor.
     */
    public function __construct(Database $database)
    {
        $this->userFactory = new UserFactory();
        $this->userRepository = new UserRepository($database);
    }

    /**
     * @return array
     */
    public function getAllUsers(): array
    {
        $userArray = [];

        $users = $this->userRepository->getAllUser();

        foreach ($users as $userData) {
            $userArray[] = $this->userFactory->getUserFromObject($userData);
        }

        return $userArray;
    }
}