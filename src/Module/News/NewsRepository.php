<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;

/**
 * Class NewsRepository
 * @package Project\Module\News
 */
class NewsRepository
{
    protected const TABLE = 'neuigkeiten';

    /** @var Database $database */
    protected $database;

    /**
     * NewsRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     */
    public function getAllNews(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        return $this->database->fetchAll($query);
    }

    /**
     * @return array
     */
    public function getAllNewsOrderByDate(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);

        $query->orderBy('datum', Query::DESC);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $newsId
     * @return mixed
     */
    public function getNewsByNewsId(Id $newsId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('newsId', '=', $newsId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param News $news
     * @return bool
     */
    public function saveNewsToDatabase(News $news): bool
    {
        if (!empty($this->getNewsByNewsId($news->getNewsId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('newsId', $news->getNewsId()->toString());
            $query->set('titel', $news->getTitel()->getTitle());
            $query->set('text', $news->getText()->getText());
            $query->set('datum', $news->getDatum()->toString());

            $query->where('newsId', '=', $news->getNewsId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('newsId', $news->getNewsId()->toString());
        $query->insert('titel', $news->getTitel()->getTitle());
        $query->insert('text', $news->getText()->getText());
        $query->insert('datum', $news->getDatum()->toString());

        $result = $this->database->execute($query);
        return $result;
    }

    /**
     * @param News $news
     * @return bool
     */
    public function deleteNews(News $news): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('newsId', '=', $news->getNewsId()->toString());

        return $this->database->execute($query);
    }
}