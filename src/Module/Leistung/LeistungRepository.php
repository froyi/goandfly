<?php
declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class LeistungRepository
 * @package Project\Module\Leistung
 */
class LeistungRepository
{
    protected const TABLE = 'leistung';

    /** @var  Database $database */
    protected $database;

    /**
     * LeistungRepository constructor.
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
    public function getAllLeistungen(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     */
    public function getLeistungByReiseId(Id $reiseId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());

        return $this->database->fetch($query);
    }

    /**
     *
     *
     * @param Id $leistungId
     * @return mixed
     */
    public function getLeistungByLeistungId(Id $leistungId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('leistungId', '=', $leistungId->toString());

        return $this->database->fetch($query);
    }

    /**
     *
     *
     * @param Leistung $leistung
     * @return bool
     */
    public function saveLeistung(Leistung $leistung): bool
    {
        if (!empty($this->getLeistungByLeistungId($leistung->getLeistungId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('leistungId', $leistung->getLeistungId()->toString());
            $query->set('reiseId', $leistung->getReiseId()->toString());
            $query->set('text', $leistung->getText()->getText());

            $query->where('leistungId', '=', $leistung->getLeistungId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('leistungId', $leistung->getLeistungId()->toString());
        $query->insert('reiseId', $leistung->getReiseId()->toString());
        $query->insert('text', $leistung->getText()->getText());

        return $this->database->execute($query);
    }
}