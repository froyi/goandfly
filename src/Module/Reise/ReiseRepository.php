<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class ReiseRepository
 * @package Project\Module\Reise
 */
class ReiseRepository
{
    protected const TABLE = 'reise';

    protected const REISE_REGION_TABLE = 'reise_region';

    protected const REISE_TAGS_TABLE = 'reise_tag';

    /** @var Database $database */
    protected $database;

    /**
     * ReiseRepository constructor.
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
    public function getAllReisen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @return array
     */
    public function getAllVisibleReisen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('sichtbar', '>=', date('Y-m-d'));

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return mixed
     */
    public function getReiseByReiseId(Id $reiseId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param int|null $amount
     *
     * @return array
     */
    public function getAllVisibleSortedReisen(int $amount = null): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('sichtbar', '>=', date('Y-m-d'));
        $query->orderBy('bearbeitet', Query::DESC);

        if ($amount !== null) {
            $query->limit($amount);
        }

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $regionId
     * @param int|null $amount
     *
     * @return array
     */
    public function getAllVisibleReisenByRegionId(Id $regionId, int $amount = null): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        $query->addTable(self::REISE_REGION_TABLE);

        $query->where('sichtbar', '>=', date('Y-m-d'));
        $query->andWhere('regionId', '=', $regionId->toString());
        $query->andWhere(self::TABLE . '.reiseId', '=', self::REISE_REGION_TABLE . '.reiseId', true);
        $query->orderBy('bearbeitet', Query::DESC);

        if ($amount !== null) {
            $query->limit($amount);
        }

        return $this->database->fetchAll($query);
    }

    /**
     * @param array $tags
     * @param Id|null $regionId
     * @param int|null $amount
     * @return array
     */
    public function getReiseByTagsAndRegionId(array $tags = [], Id $regionId = null, int $amount = null): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        $query->addTable(self::REISE_REGION_TABLE);
        $query->addTable(self::REISE_TAGS_TABLE);

        $query->where('sichtbar', '>=', date('Y-m-d'));

        $query->andWhere(self::TABLE . '.reiseId', '=', self::REISE_REGION_TABLE . '.reiseId', true);
        $query->andWhere(self::TABLE . '.reiseId', '=', self::REISE_TAGS_TABLE . '.reiseId', true);

        if ($regionId !== null) {
            $query->andWhere('regionId', '=', $regionId->toString());
        }

        foreach ($tags as $tag) {
            $query->andOrWhere('tagId', '=', $tag->getTagId()->toString());
        }

        $query->orderBy('bearbeitet', Query::DESC);

        if ($amount !== null) {
            $query->limit($amount);
        }

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $regionId
     *
     * @return array
     */
    public function getAllReisenByRegionId(Id $regionId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->addTable(self::REISE_REGION_TABLE);

        $query->where(self::TABLE . '.reiseId', '=', self::REISE_REGION_TABLE . '.reiseId', true);

        $query->andWhere('regionId', '=', $regionId->toString());

        $query->orderBy('bearbeitet', Query::DESC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Reiseveranstalter $reiseveranstalter
     *
     * @return array
     */
    public function getAllReisenByVeranstalter(Reiseveranstalter $reiseveranstalter): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('veranstalter', '=', $reiseveranstalter->getReiseveranstalter()->getName());
        $query->orderBy('bearbeitet', Query::DESC);

        return $this->database->fetchAll($query);
    }

    /**
     * @return array
     */
    public function getAllVeranstalter(): array
    {
        return $this->database->fetchAllQuery('SELECT DISTINCT veranstalter FROM reise');
    }
}