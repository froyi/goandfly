<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\GenericValueObject\Id;
use Project\Module\News\NewsService;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;
use Project\Utilities\Tools;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    public function indexAction(): void
    {
        $startpageOfferAmount = $this->configuration->getEntryByName('startpage-offer');

        $newsService = new NewsService($this->database);
        $news = $newsService->getAllNewsOrderByDate();

        $this->viewRenderer->addViewConfig('news', $news);

        $reiseService = new ReiseService($this->database);
        $reiseContainer = $reiseService->getAllShuffledReisenInContainer($startpageOfferAmount);

        $this->viewRenderer->addViewConfig('teaserReisen', $reiseContainer->getTeaserReiseListe());
        $this->viewRenderer->addViewConfig('bottomReisen', $reiseContainer->getBottomReiseListe());

        // TagListe
        $tagService = new TagService($this->database);
        $tags = $tagService->getAllTags();

        $this->viewRenderer->addViewConfig('tagListe', $tags);


        $this->viewRenderer->addViewConfig('page', 'home');
        $this->viewRenderer->renderTemplate();
    }

    public function reiseAction(): void
    {
        $reiseId = Tools::getValue('reiseId');

        if ($reiseId === false) {
            $this->notFoundAction();
        }
        
        $reiseService = new ReiseService($this->database);
        $reise = $reiseService->getCompleteReiseByReiseId(Id::fromString($reiseId));

        if ($reise === null) {
            $this->notFoundAction();
        }

        $this->viewRenderer->addViewConfig('reise', $reise);


        if ($reise->getRegion() !== null) {
            $reiseRecommenderAmount = $this->configuration->getEntryByName('reise-recommender-offer');
            $reiseRecommender = $reiseService->getReiseRecommenderByRegionId($reise->getRegion()->getRegionId(), $reiseRecommenderAmount);

            if ($reiseRecommender !== null) {
                $this->viewRenderer->addViewConfig('reiseRecommender', $reiseRecommender);
            }
        }

        $this->viewRenderer->addViewConfig('page', 'reise');
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