<?php declare(strict_types=1);

namespace Project\Module\Teaserbild;

use Project\Module\Database\Database;

/**
 * Class TeaserbildRepository
 * @package Project\Module\Teaserbild
 */
class TeaserbildRepository
{
    protected const TABLE = 'teaserbild';

    /** @var  Database $database */
    protected $database;

    /**
     * TeaserbildRepository constructor.
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
    public function getAllTeaserbilder(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }
}