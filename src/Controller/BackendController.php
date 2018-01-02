<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Image;
use Project\Module\Migration\Migrate;
use Project\Module\News\News;
use Project\Module\News\NewsService;
use Project\Module\Region\RegionService;
use Project\Module\Reise\ReiseService;
use Project\Module\Tag\TagService;
use Project\Routing;
use Project\Utilities\Tools;

/**
 * Class BackendController
 * @package Project\Controller
 */
class BackendController extends DefaultController
{
    /**
     * BackendController constructor.
     */
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

        if ($this->loggedInUser === null) {
            $this->showStandardPage(Routing::ERROR_ROUTE);
        }
    }
    public function migrateAction(): void
    {
        $oldDatabase = new Database($this->configuration, 'goandfly');
        $migrate = new Migrate($oldDatabase, $this->database);

        $migrate->migrate();
    }

    public function loggedInAction(): void
    {
        $reiseService = new ReiseService($this->database);

        $regionService = new RegionService($this->database);
        $regions = $regionService->getAllRegionsWithReisen($reiseService);

        $this->viewRenderer->addViewConfig('regionsWithReisen', $regions);

        $veranstalter = $reiseService->getVeranstalterWithReisen();

        $this->viewRenderer->addViewConfig('veranstalterWithReisen', $veranstalter);

        $tagService = new TagService($this->database);

        $tags = $tagService->getTagsWithReisen($reiseService);

        $this->viewRenderer->addViewConfig('tagsWithReisen', $tags);

        $this->getNews();

        $this->viewRenderer->addViewConfig('page', 'loggedin');
        $this->viewRenderer->renderTemplate();
    }

    public function erstelleReiseAction(): void
    {
        $params = $_POST;

        /** @var null|Image $imageVorschauBild */
        $imageVorschauBild = null;
        if (Tools::getFile('vorschauBild') !== false) {
            $imageVorschauBild = Image::fromUploadWithSave(Tools::getFile('vorschauBild'), Image::PATH_REISE);
        }
        $params['vorschauBild'] = $imageVorschauBild;

        /** @var null|Image $imageKartenBild */
        $imageKartenBild = null;
        if (Tools::getFile('kartenBild') !== false) {
            $imageKartenBild = Image::fromUploadWithSave(Tools::getFile('kartenBild'), Image::PATH_KARTE);
        }
        $params['kartenBild'] = $imageKartenBild;

        /** @var null|Image $imageTeaserBild */
        $imageTeaserBild = null;
        if (Tools::getFile('teaserBild') !== false) {
            $imageTeaserBild = Image::fromUploadWithSave(Tools::getFile('teaserBild'), Image::PATH_REISE);
        }
        $params['teaserBild'] = $imageTeaserBild;

        $reiseService = new ReiseService($this->database);
        $regionService = new RegionService($this->database);

        $reise = $reiseService->getReiseByParams($params, $regionService);

        /** @var array $parameter */
        $parameter = ['notificationCode' => 'reiseInsertError', 'notificationStatus' => 'error'];
        if ($reiseService->saveReiseToDatabase($reise) === true) {
            $parameter = ['notificationCode' => 'reiseInsertSuccess', 'notificationStatus' => 'success'];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    public function erstelleNeuigkeitenAction(): void
    {
        $newsService = new NewsService($this->database);

        $news = $newsService->getNewsByParams($_POST);

        /** @var array $parameter */
        $parameter = ['notificationCode' => 'newsInsertError', 'notificationStatus' => 'error'];
        if ($news instanceof News && $newsService->saveNewsToDatabase($news) === true) {
            $parameter = ['notificationCode' => 'newsInsertSuccess', 'notificationStatus' => 'success'];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    public function bearbeiteNeuigkeitenAction(): void
    {
        $newsService = new NewsService($this->database);

        $news = $newsService->getNewsByParams($_POST);

        if (Tools::getValue('loeschenNeuigkeit') !== false) {
            $newsService->deleteNews($news);
            $parameter = ['notificationCode' => 'newsDeleteSuccess', 'notificationStatus' => 'success'];
            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        /** @var array $parameter */
        $parameter = ['notificationCode' => 'newsUpdateError', 'notificationStatus' => 'error'];
        if ($news instanceof News && $newsService->saveNewsToDatabase($news) === true) {
            $parameter = ['notificationCode' => 'newsUpdateSuccess', 'notificationStatus' => 'success'];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }
}