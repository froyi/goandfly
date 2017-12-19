<?php declare(strict_types=1);

namespace Project\Module\Tag;

use Project\Module\Database\Database;

/**
 * Class TagRepository
 * @package Project\Module\Tag
 */
class TagRepository
{
    protected const TABLE = 'tag';

    /** @var  Database $database */
    protected $database;

    /**
     * TagRepository constructor.
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
    public function getAllTags(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}