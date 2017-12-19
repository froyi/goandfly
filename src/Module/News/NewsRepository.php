<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;

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
}