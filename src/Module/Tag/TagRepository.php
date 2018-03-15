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

    protected const ORDER_BY_NAME = 'name';


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
     * @return array
     */
    public function getAllTagsSorted(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->orderBy(self::ORDER_BY_NAME, Query::ASC);

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

    /**
     *
     *
     * @param Id $reiseId
     * @return bool
     */
    public function deleteAllTagsFromReise(Id $reiseId): bool
    {
        $query = $this->database->getNewDeleteQuery(self::REISE_TAG_TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->execute($query);
    }

    /**
     *
     *
     * @param Id $tagId
     * @param Id $reiseId
     * @return bool
     */
    public function saveTagToReise(Tag $tag, Id $reiseId): bool
    {
        $query = $this->database->getNewInsertQuery(self::REISE_TAG_TABLE);
        $query->insert('reiseTagId', Id::generateId()->toString());
        $query->insert('tagId', $tag->getTagId()->toString());
        $query->insert('reiseId', $reiseId->toString());

        return $this->database->execute($query);
    }
}