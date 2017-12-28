<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\GenericValueObject\Id;
use Project\Module\News\NewsService;
use Project\Module\Region\RegionService;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;
use Project\Utilities\Tools;
use Project\View\JsonModel;

/**
 * Class BackendController
 * @package Project\Controller
 */
class JsonController extends DefaultController
{
    /** @var JsonModel $jsonModel */
    protected $jsonModel;

    /**
     * JsonController constructor.
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

        $this->jsonModel = new JsonModel();
    }

    public function filterReisenAction()
    {
        $tagService = new TagService($this->database);

        $tagIds = Tools::getValue('tagIds');

        $tags = [];
        if ($tagIds !== false) {
            $tags = $tagService->getTagsByTagIdArray($tagIds);
        }
        $tagService->saveTagsToSession($tags);

        $regionId = null;
        if (Tools::getValue('regionId') !== false) {
            $regionId = Tools::getValue('regionId');
        }

        $regionService = new RegionService($this->database);
        $regionService->saveRegionToSession($regionId);

        $newsService = new NewsService($this->database);
        $news = $newsService->getAllNewsOrderByDate();

        $this->viewRenderer->addViewConfig('news', $news);

        $reiseService = new ReiseService($this->database);
        $reiseContainer = $reiseService->getAllTagAndRegionReisenInContainer($tags, $regionId);

        $this->viewRenderer->addViewConfig('teaserReisen', $reiseContainer->getTeaserReiseListe());
        $this->viewRenderer->addViewConfig('bottomReisen', $reiseContainer->getBottomReiseListe());

        $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('page/home.twig'));

        $this->jsonModel->send();
    }
}