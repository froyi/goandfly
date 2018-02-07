<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;
use Project\Module\Region\Region;

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
            $query->limit($amount * 2);
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

    /**
     * @param Id $tagId
     * @return array
     */
    public function getAllReisenByTagId(Id $tagId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->addTable(self::REISE_TAGS_TABLE);

        $query->where(self::TABLE . '.reiseId', '=', self::REISE_TAGS_TABLE . '.reiseId', true);

        $query->andWhere('tagId', '=', $tagId->toString());

        $query->orderBy('bearbeitet', Query::DESC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Reise $reise
     * @return bool
     */
    public function saveReiseToDatabase(Reise $reise): bool
    {
        if (!empty($this->getReiseByReiseId($reise->getReiseId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('reiseId', $reise->getReiseId()->toString());
            $query->set('kurzbeschreibung', $reise->getKurzbeschreibung()->getText());
            $query->set('beschreibung', $reise->getBeschreibung()->getText());
            $query->set('titel', $reise->getTitel()->getTitle());
            $query->set('personen', $reise->getPersonen()->getPersonen());
            $query->set('reisedauer', $reise->getReisedauer()->getReisedauer());
            $query->set('flugzeit', $reise->getFlugzeit()->getFlugzeit());
            $query->set('sprache', $reise->getSprache()->getText());
            $query->set('terrain', $reise->getTerrain()->getTerrain());
            $query->set('karte', $reise->getKarte()->toString());
            $query->set('bearbeitet', $reise->getBearbeitet()->toString());
            $query->set('teaser', $reise->getTeaser()->toString());
            $query->set('sichtbar', $reise->getSichtbar()->toString());
            $query->set('bild', $reise->getBild()->toString());
            $query->set('veranstalter', $reise->getVeranstalter()->getName());

            $query->where('reiseId', '=', $reise->getReiseId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('reiseId', $reise->getReiseId()->toString());
        $query->insert('kurzbeschreibung', $reise->getKurzbeschreibung()->getText());
        $query->insert('beschreibung', $reise->getBeschreibung()->getText());
        $query->insert('titel', $reise->getTitel()->getTitle());
        $query->insert('personen', $reise->getPersonen()->getPersonen());
        $query->insert('reisedauer', $reise->getReisedauer()->getReisedauer());
        $query->insert('flugzeit', $reise->getFlugzeit()->getFlugzeit());
        $query->insert('sprache', $reise->getSprache()->getText());
        $query->insert('terrain', $reise->getTerrain()->getTerrain());
        $query->insert('karte', $reise->getKarte()->toString());
        $query->insert('bearbeitet', $reise->getBearbeitet()->toString());
        $query->insert('teaser', $reise->getTeaser()->toString());
        $query->insert('sichtbar', $reise->getSichtbar()->toString());
        $query->insert('bild', $reise->getBild()->toString());
        $query->insert('veranstalter', $reise->getVeranstalter()->getName());

        return $this->database->execute($query);
    }

    /**
     * @param Reise $reise
     * @return bool
     */
    public function deleteReise(Reise $reise): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('reiseId', '=', $reise->getReiseId()->toString());

        return $this->database->execute($query);
    }

    /**
     * @param Reise $reise
     * @param Region $region
     * @return array
     */
    public function getReiseRegion(Reise $reise, Region $region)
    {
        $query = $this->database->getNewSelectQuery(self::REISE_REGION_TABLE);
        $query->where('reiseId', '=', $reise->getReiseId()->toString());
        $query->andWhere('regionId', '=', $region->getRegionId()->toString());

        return $this->database->fetchAll($query);
    }

    /**
     * @param Reise $reise
     * @param Region $region
     * @return bool
     */
    public function saveReiseRegionToDatabase(Reise $reise, Region $region): bool
    {
        if (empty($this->getReiseRegion($reise, $region))) {
            $query = $this->database->getNewInsertQuery(self::REISE_REGION_TABLE);

            $query->insert('reiseRegionId', Id::generateId()->toString());
            $query->insert('reiseId', $reise->getReiseId()->toString());
            $query->insert('regionId', $region->getRegionId()->toString());

            return $this->database->execute($query);
        }

        return true;
    }

    /**
     *
     *
     * @param Reise $reise
     * @return bool
     */
    public function deleteReiseRegionFromDatabase(Reise $reise): bool
    {
        $query = $this->database->getNewDeleteQuery(self::REISE_REGION_TABLE);
        $query->where('reiseId', '=', $reise->getReiseId()->toString());

        return $this->database->execute($query);
    }
}