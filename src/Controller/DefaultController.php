<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Continent\ContinentService;
use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\News\NewsService;
use Project\Module\Region\RegionService;
use Project\Module\Reise\Reise;
use Project\Module\Reise\ReiseContainer;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;
use Project\Module\User\User;
use Project\Module\User\UserService;
use Project\Service\JsPluginService;
use Project\Utilities\Notification;
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

    /** @var  User $loggedInUser */
    protected $loggedInUser;

    /** @var UserService $userService */
    protected $userService;

    /** @var  Notification $notification */
    protected $notification;

    /**
     * DefaultController constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        $this->configuration = $configuration;
        $this->viewRenderer = new ViewRenderer($this->configuration);
        $this->database = new Database($this->configuration);
        $this->userService = new UserService($this->database);
        $this->notification = new Notification($this->configuration);

        if (Tools::getValue('userId') !== false) {
            $userId = Id::fromString(Tools::getValue('userId'));
            $this->loggedInUser = $this->userService->getLogedInUserByUserId($userId);
        }

        $this->setDefaultViewConfig($routeName);

        $this->setDefaultData();

        $this->setNotifications();

        $this->setJsPackages($routeName);
    }

    /**
     * Sets default view parameter for sidebar etc.
     */
    protected function setDefaultViewConfig(string $routeName): void
    {
        $this->viewRenderer->addViewConfig('page', 'notfound');
        $this->viewRenderer->addViewConfig('route', $routeName);
        $this->viewRenderer->addViewConfig('teaserBild', 'templates/goandfly/img/partner_teaser.jpg');
    }

    protected function setDefaultData(): void
    {
        $regionService = new RegionService($this->database);
        $this->viewRenderer->addViewConfig('regions', $regionService->getAllRegions());

        $continentService = new ContinentService($this->database);
        $this->viewRenderer->addViewConfig('continents', $continentService->getAllContinentsWithRegionList());

        /**
         * Logged In User
         */
        if ($this->loggedInUser !== null) {
            $this->viewRenderer->addViewConfig('loggedInUser', $this->loggedInUser);
        }
    }

    /**
     *
     *
     * @param string $routeName
     */
    protected function setJsPackages(string $routeName): void
    {
        $jsPlugInService = new JsPluginService($this->configuration);

        $jsMainPackage = $jsPlugInService->getMainPackages();
        $this->viewRenderer->addViewConfig('jsPlugins', $jsMainPackage);

        $jsRoutePackage = $jsPlugInService->getPackagesByRouteName($routeName);
        $this->viewRenderer->addViewConfig('jsRoutePlugins', $jsRoutePackage);
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

    /**
     * @param bool $isJson
     * @return ReiseContainer
     */
    protected function getReisenContainer(bool $isJson = false): ReiseContainer
    {
        // Tags
        $tagService = new TagService($this->database);

        // unset data for new requested ones
        if ($isJson === true) {
            $tagService->unsetTagsInSession();
        }

        $tagIds = Tools::getValue('tagIds');

        $tags = [];
        if ($tagIds !== false) {
            $tags = $tagService->getTagsByTagIdArray($tagIds);
        } else {
            $tagIds = [];
        }

        $tagService->saveTagsToSession($tags);
        $this->viewRenderer->addViewConfig('activeTags', $tagIds);

        // Region
        $regionId = null;
        $regionService = new RegionService($this->database);

        /** redirect if user removed region */
        if (Tools::getValue('regionReiseLink') !== false && Tools::getValue('regionId') !== false) {
            $regionService->saveRegionToSession($regionId);

            header('Location: ' . Tools::getRouteUrl('index'));
            exit;
        }

        if (Tools::getValue('regionId') !== false) {
            $regionId = Id::fromString(Tools::getValue('regionId'));
            $this->viewRenderer->addViewConfig('regionReiseLink', true);

            $region = $regionService->getRegionByRegionId($regionId);
            $this->viewRenderer->addViewConfig('regionReise', $region);
        }

        $regionService->saveRegionToSession($regionId);

        $startpageOfferAmount = null;
        if (empty($tags) && empty($regionId)) {
            $startpageOfferAmount = $this->configuration->getEntryByName('startpage-offer');
        }

        $reiseService = new ReiseService($this->database);
        $reiseContainer = $reiseService->getAllTagAndRegionReisenInContainer($tags, $regionId, $startpageOfferAmount);

        $this->viewRenderer->addViewConfig('teaserReisen', $reiseContainer->getTeaserReiseListe());
        $this->viewRenderer->addViewConfig('bottomReisen', $reiseContainer->getBottomReiseListe());

        return $reiseContainer;
    }

    protected function generateTeaserBildByReiseContainer(ReiseContainer $reiseContainer): void
    {
        $reiseListe = $reiseContainer->getReiseListe();

        if (empty($reiseListe) === false) {
            $key = array_rand($reiseListe);

            /** @var Reise $reise */
            $reise = $reiseListe[$key];

            $this->setTeaserBild($reise);
        }
    }

    protected function setTeaserBild(Reise $reise): void
    {
        $this->viewRenderer->addViewConfig('teaserBild', $reise->getTeaser()->toString());
    }

    /**
     *  adding notifications to the template
     */
    protected function setNotifications(): void
    {
        if (Tools::getValue('notificationStatus') !== false && Tools::getValue('notificationCode') !== false) {
            $this->notification->setNotificationCode(Tools::getValue('notificationCode'));
            $this->notification->setNotificationStatus(Tools::getValue('notificationStatus'));

            $this->viewRenderer->addViewConfig('notificationStatus', $this->notification->getNotificationStatus());
            $this->viewRenderer->addViewConfig('notificationMessage', $this->notification->getNotificationMessage());
        }
    }
}