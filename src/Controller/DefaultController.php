<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Continent\ContinentService;
use Project\Module\Database\Database;
use Project\Module\News\NewsService;
use Project\Module\Region\RegionService;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;
use Project\Utilities\Tools;
use Project\View\ViewRenderer;

/**
 * Class DefaultController
 * @package Project\Controller
 */
class DefaultController
{
    /** @var ViewRenderer $viewRenderer */
    protected $viewRenderer;

    /** @var Configuration $configuration */
    protected $configuration;

    /** @var Database $database */
    protected $database;

    /**
     * DefaultController constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->viewRenderer = new ViewRenderer($this->configuration);
        $this->database = new Database($this->configuration);

        $this->setDefaultViewConfig();

        $this->setDefaultData();
    }

    /**
     * Sets default view parameter for sidebar etc.
     */
    protected function setDefaultViewConfig(): void
    {
        $this->viewRenderer->addViewConfig('page', 'notfound');
        $this->viewRenderer->addViewConfig('teaserBild', 'partner_teaser.jpg');

    }

    protected function setDefaultData(): void
    {
        $regionService = new RegionService($this->database);
        $this->viewRenderer->addViewConfig('regions', $regionService->getAllRegions());

        $continentService = new ContinentService($this->database);
        $this->viewRenderer->addViewConfig('continents', $continentService->getAllContinentsWithRegionList($regionService));
    }

    /**
     * error action
     * @throws \InvalidArgumentException
     */
    public function errorPageAction(): void
    {
        $this->showStandardPage('error');
    }

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     */
    protected function showStandardPage(string $name): void
    {
        try {
            $this->viewRenderer->addViewConfig('page', $name);

            $this->viewRenderer->renderTemplate();
        } catch (\InvalidArgumentException $error) {
            $this->notFoundAction();
        }
    }

    /**
     * not found action
     * @throws \InvalidArgumentException
     */
    public function notFoundAction(): void
    {
        try {
            $this->viewRenderer->addViewConfig('page', 'notfound');

            $this->viewRenderer->renderTemplate();
        } catch (\Twig_Error_Loader $error) {
            echo 'Alles ist kaputt!';
        }
    }

    protected function getNews(): void
    {
        $newsService = new NewsService($this->database);
        $news = $newsService->getAllNewsOrderByDate();

        $this->viewRenderer->addViewConfig('news', $news);
    }

    protected function getTagListe(): void
    {
        $tagService = new TagService($this->database);
        $tags = $tagService->getAllTags();

        $this->viewRenderer->addViewConfig('tagListe', $tags);
    }

    protected function getReisenContainer(): void
    {
        // Tags
        $tagService = new TagService($this->database);

        $tagIds = Tools::getValue('tagIds');

        $tags = [];
        if ($tagIds !== false) {
            $tags = $tagService->getTagsByTagIdArray($tagIds);
        }

        $tagService->saveTagsToSession($tags);

        // Region
        $regionId = null;
        if (Tools::getValue('regionId') !== false) {
            $regionId = Tools::getValue('regionId');
        }

        $regionService = new RegionService($this->database);
        $regionService->saveRegionToSession($regionId);

        $startpageOfferAmount = null;
        if (empty($tags) && empty($regionId)) {
            $startpageOfferAmount = $this->configuration->getEntryByName('startpage-offer');
        }

        $reiseService = new ReiseService($this->database);
        $reiseContainer = $reiseService->getAllTagAndRegionReisenInContainer($tags, $regionId, $startpageOfferAmount);

        $this->viewRenderer->addViewConfig('teaserReisen', $reiseContainer->getTeaserReiseListe());
        $this->viewRenderer->addViewConfig('bottomReisen', $reiseContainer->getBottomReiseListe());
    }
}