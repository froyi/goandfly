<?php declare(strict_types=1);

namespace Project\Module\Tag;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class TagRepository
 * @package Project\Module\Tag
 */
class TagRepository
{
    protected const TABLE = 'tag';

    protected const REISE_TAG_TABLE = 'reise_tag';

    protected const ORDER_BY_POSITION = 'position';

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
        $query->orderBy(self::ORDER_BY_POSITION, Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getTagsByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::REISE_TAG_TABLE);
        $query->addTable(self::TABLE);
        $query->where(self::TABLE . '.tagId', '=', self::REISE_TAG_TABLE . '.tagId', true);
        $query->andWhere('reiseId', '=', $reiseId->toString());
        $query->orderBy(self::ORDER_BY_POSITION, Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $tagId
     *
     * @return array
     */
    public function getTagByTagId(Id $tagId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('tagId', '=', $tagId->toString());
        $query->orderBy(self::ORDER_BY_POSITION, Query::ASC);

        return $this->database->fetch($query);
    }
}