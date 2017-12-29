<?php
declare(strict_types = 1);

namespace Project\Module\User;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;

class UserRepository
{
    const TABLE = 'user';

    const ORDERBY = 'userId';

    const ORDERKIND = 'ASC';

    /** @var  Database $database */
    protected $database;

    /**
     * UserRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getUserByEmail(Email $email)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('email', '=', $email->getEmail());

        return $this->database->fetch($query);
    }

    public function getUserByUserId(Id $userId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('userId', '=', $userId->toString());

        return $this->database->fetch($query);
    }
}