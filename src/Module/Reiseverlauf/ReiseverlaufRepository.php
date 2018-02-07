<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class ReiseverlaufRepository
 * @package Project\Module\Reiseverlauf
 */
class ReiseverlaufRepository
{
    protected const TABLE = 'reiseverlauf';

    /** @var  Database $database */
    protected $database;

    /**
     * ReiseverlaufRepository constructor.
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
    public function getAllReiseverlauf(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getReiseverlaufByReiseId(Id $reiseId): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseId', '=', $reiseId->toString());
        $query->orderBy('reisetag', Query::ASC);

        return $this->database->fetchAll($query);
    }

    /**
     *
     *
     * @param Id $reiseverlaufId
     * @return mixed
     */
    public function getReiseverlaufByReiseverlaufId(Id $reiseverlaufId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('reiseverlaufId', '=', $reiseverlaufId->toString());

        return $this->database->fetch($query);
    }

    /**
     *
     *
     * @param Reiseverlauf $reiseverlauf
     * @return bool
     */
    public function saveReiseverlaufToDatabase(Reiseverlauf $reiseverlauf): bool
    {
        if (!empty($this->getReiseverlaufByReiseverlaufId($reiseverlauf->getReiseverlaufId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('reiseverlaufId', $reiseverlauf->getReiseverlaufId()->toString());
            $query->set('reiseId', $reiseverlauf->getReiseId()->toString());
            $query->set('reisetag', $reiseverlauf->getReisetag()->getReisetag());
            $query->set('titel', $reiseverlauf->getTitel()->getTitle());
            $query->set('beschreibung', $reiseverlauf->getBeschreibung()->getText());

            $query->where('reiseverlaufId', '=', $reiseverlauf->getReiseverlaufId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('reiseverlaufId', $reiseverlauf->getReiseverlaufId()->toString());
        $query->insert('reiseId', $reiseverlauf->getReiseId()->toString());
        $query->insert('reisetag', $reiseverlauf->getReisetag()->getReisetag());
        $query->insert('titel', $reiseverlauf->getTitel()->getTitle());
        $query->insert('beschreibung', $reiseverlauf->getBeschreibung()->getText());

        return $this->database->execute($query);
    }

    /**
     *
     *
     * @param Id $reiseverlaufId
     * @return bool
     */
    public function deleteReiseverlaufFromDatabase(Id $reiseverlaufId): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('reiseverlaufId', '=', $reiseverlaufId->toString());

        return $this->database->execute($query);
    }
}