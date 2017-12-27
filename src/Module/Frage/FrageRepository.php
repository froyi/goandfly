<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class FrageRepository
 * @package Project\Module\Frage
 */
class FrageRepository
{
    protected const TABLE = 'frage';

    /** @var Database $database */
    protected $database;

    /**
     * FrageRepository constructor.
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
    public function getAllFragen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getFragenByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->fetchAll($query);
    }
}