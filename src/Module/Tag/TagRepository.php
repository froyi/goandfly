<?php declare(strict_types=1);

namespace Project\Module\Tag;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class TagRepository
 * @package Project\Module\Tag
 */
class TagRepository
{
    protected const TABLE = 'tag';

    protected const REISE_TAG_TABLE = 'reise_tag';

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

    /**
     * @param Id $reiseId
     * @return array
     */
    public function getTagsByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::REISE_TAG_TABLE);
        $query->addTable(self::TABLE);
        $query->where(self::TABLE . '.tagId', '=', self::REISE_TAG_TABLE . '.tagId', true);
        $query->andWhere('reiseId', '=', $reiseId->toString());

        return $this->database->fetchAll($query);
    }
}