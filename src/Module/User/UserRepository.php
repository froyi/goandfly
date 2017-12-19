<?php declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\Database\Database;

/**
 * Class UserRepository
 * @package Project\Module\User
 */
class UserRepository
{
    protected const TABLE = 'user';

    /** @var  Database $database */
    protected $database;

    /**
     * UserRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllUser(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}