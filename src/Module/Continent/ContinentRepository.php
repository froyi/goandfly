<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class ContinentRepository
 * @package Project\Module\Continent
 */
class ContinentRepository
{
    protected const TABLE = 'continent';

    /** @var Database $database */
    protected $database;

    /**
     * ContinentRepository constructor.
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
    public function getAllContinents(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $continentId
     */
    public function getContinentByContinentId(Id $continentId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('continentId', '=', $continentId->toString());

        return $this->database->fetch($query);
    }
}