<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class TerminRepository
 * @package Project\Module\Termin
 */
class TerminRepository
{
    protected const TABLE = 'termin';

    /** @var  Database $database */
    protected $database;

    /**
     * TerminRepository constructor.
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
    public function getAllTermine(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getTermineByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());
        $query->orderBy('start', Query::ASC);

        return $this->database->fetchAll($query);
    }
}