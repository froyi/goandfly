<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;

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
            $newsArray[] = $this->newsFactory->getNewsFromObject($newsData);
        }

        return $newsArray;
    }
}