<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\News\NewsService;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    public function indexAction(): void
    {
        $newsService = new NewsService($this->database);
        $news = $newsService->getAllNewsOrderByDate();

        $this->viewRenderer->addViewConfig('news', $news);

        $tagService = new TagService($this->database);

        $reiseService = new ReiseService($this->database);
        $reiseContainer = $reiseService->getAllReisenInContainer($tagService);


        $this->viewRenderer->addViewConfig('teaserReisen', $reiseContainer->getTeaserReiseListe());
        $this->viewRenderer->addViewConfig('bottomReisen', $reiseContainer->getBottomReiseListe());


        $this->viewRenderer->addViewConfig('page', 'home');
        $this->viewRenderer->renderTemplate();
    }

    public function ueberUnsAction(): void
    {
        $this->showStandardPage('ueberUns');
    }

    public function partnerAction(): void
    {
        $this->showStandardPage('partner');
    }

    public function kontaktAction(): void
    {
        $this->showStandardPage('kontakt');
    }

    public function impressumAction(): void
    {
        $this->showStandardPage('impressum');
    }

    public function diamirAction(): void
    {
        $this->showStandardPage('diamir');
    }

}