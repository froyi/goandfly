<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;
use Project\Module\Database\Query;

/**
 * Class NewsRepository
 * @package Project\Module\News
 */
class NewsRepository
{
    protected const TABLE = 'neuigkeiten';

    /** @var Database $database */
    protected $database;

    /**
     * NewsRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllNews(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @return array
     */
    public function getAllNewsOrderByDate(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        $query->orderBy('datum', Query::DESC);

        return $this->database->fetchAll($query);
    }
}