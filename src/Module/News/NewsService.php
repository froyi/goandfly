<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;

/**
 * Class NewsService
 * @package Project\Module\News
 */
class NewsService
{
    /** @var NewsFactory $newsFactory */
    protected $newsFactory;

    /** @var NewsRepository $newsRepository */
    protected $newsRepository;

    /**
     * NewsService constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->newsFactory = new NewsFactory();
        $this->newsRepository = new NewsRepository($database);
    }

    /**
     * @return array
     */
    public function getAllNews(): array
    {
        $newsArray = [];

        $news = $this->newsRepository->getAllNews();

        foreach ($news as $newsData) {
            $singleNews = $this->newsFactory->getNewsFromObject($newsData);
            $newsArray[$singleNews->getNewsId()->toString()] = $singleNews;
        }

        return $newsArray;
    }

    /**
     * @return array
     */
    public function getAllNewsOrderByDate(): array
    {
        $newsArray = [];

        $news = $this->newsRepository->getAllNewsOrderByDate();

        foreach ($news as $newsData) {
            $singleNews = $this->newsFactory->getNewsFromObject($newsData);
            $newsArray[] = $singleNews;
        }

        return $newsArray;
    }

    /**
     * @param array $parameter
     * @return null|News
     */
    public function getNewsByParams(array $parameter): ?News
    {
        /** @var \stdClass $object */
        $object = (object)$parameter;

        if (empty($object->newsId)) {
            $object->newsId = Id::generateId()->toString();
        }

        if (empty($object->datum)) {
            $object->datum = Date::fromValue('now')->toString();
        }

        if ($this->newsFactory->isObjectValid($object) === true) {
            return $this->newsFactory->getNewsFromObject($object);
        }

        return null;
    }

    /**
     * @param News $news
     * @return bool
     */
    public function saveNewsToDatabase(News $news): bool
    {
        return $this->newsRepository->saveNewsToDatabase($news);
    }

    /**
     * @param Id $newsId
     * @return null|News
     */
    public function getNewsByNewsId(Id $newsId): ?News
    {
        $newsData = $this->newsRepository->getNewsByNewsId($newsId);

        if (empty($newsData) || $this->newsFactory->isObjectValid($newsData) === false) {
            return null;
        }

        return $this->newsFactory->getNewsFromObject($newsData);
    }

    /**
     * @param News $news
     * @return bool
     */
    public function deleteNews(News $news): bool
    {
        return $this->newsRepository->deleteNews($news);
    }
}