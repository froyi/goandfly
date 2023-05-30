<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Database\Database;
use Project\Module\Frage\FrageService;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\Migration\Migrate;
use Project\Module\News\News;
use Project\Module\News\NewsService;
use Project\Module\Region\RegionService;
use Project\Module\Reise\Reise;
use Project\Module\Reise\ReiseService;
use Project\Module\Reiseverlauf\ReiseverlaufService;
use Project\Module\Tag\TagService;
use Project\Module\Termin\TerminService;
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
    public function __construct(Configuration $configuration, string $routeName)
    {
        parent::__construct($configuration, $routeName);

        if ($this->loggedInUser === null) {
            $this->showStandardPage(Routing::ERROR_ROUTE);
            exit;
        }
    }

    public function migrateAction(): void
    {
        $oldDatabase = new Database($this->configuration, 'goandfly');
        $migrate = new Migrate($oldDatabase, $this->database);

        $migrate->startMigration();
    }

    public function loggedInAction(): void
    {
        $reiseService = new ReiseService($this->database);

        $regionService = new RegionService($this->database);
        $regions = $regionService->getAllRegionsWithReisen($reiseService, true);

        $this->viewRenderer->addViewConfig('regionsWithReisen', $regions);

        $veranstalter = $reiseService->getVeranstalterWithReisen();

        $this->viewRenderer->addViewConfig('veranstalterWithReisen', $veranstalter);

        $tagService = new TagService($this->database);

        $tags = $tagService->getTagsWithReisen($reiseService);

        $this->viewRenderer->addViewConfig('tagsWithReisen', $tags);

        if (Tools::getValue('reiseId') !== false) {
            $this->viewRenderer->addViewConfig('activeReiseId', Id::fromString(Tools::getValue('reiseId')));
        }
        $this->viewRenderer->addViewConfig('tagsWithReisen', $tags);

        $this->getNews();

        $this->viewRenderer->addViewConfig('page', 'loggedin');
        $this->viewRenderer->renderTemplate();
    }

    public function erstelleReiseAction(): void
    {
        $reiseService = new ReiseService($this->database);

        $parameter = ['notificationCode' => 'reiseInsertError', 'notificationStatus' => 'error'];

        $reise = $this->getReiseFromParameter();

        if ($reise === null) {
            $regionService = new RegionService($this->database);

            $reisevorschau = $reiseService->getReiseVorschauByParameter((object)$_POST, $regionService);

            if ($reisevorschau !== null && $reiseService->saveReisevorschauToDatabase($reisevorschau)) {
                $parameter = ['notificationCode' => 'reisevorschauInsertSuccess', 'notificationStatus' => 'success'];
            }
        } else {
            /** @var array $parameter */

            if ($reise !== null && $reiseService->saveReiseToDatabase($reise) === true) {
                $parameter = ['notificationCode' => 'reiseInsertSuccess', 'notificationStatus' => 'success'];
            }
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    /**
     * @todo Diese Funktion muss in den ReiseService rein
     *
     *
     * @param Reise|null $reiseOld
     * @return null|Reise
     */
    protected function getReiseFromParameter($reiseOld = null): ?Reise
    {
        $object = (object)$_POST;

        /** @var null|Image $imageVorschauBild */
        $imageVorschauBild = null;
        if (Tools::getFile('vorschauBild') !== false) {
            $imageVorschauBild = Image::fromUploadWithSave(Tools::getFile('vorschauBild'), Image::USE_BILD)->toString();
        } else {
            if ($reiseOld !== null && $reiseOld->getBild() !== null) {
                $imageVorschauBild = $reiseOld->getBild()->toString();
            }
        }
        $object->bild = $imageVorschauBild;

        /** @var null|Image $imageKartenBild */
        $imageKartenBild = null;
        if (Tools::getFile('kartenBild') !== false) {
            $imageKartenBild = Image::fromUploadWithSave(Tools::getFile('kartenBild'), Image::USE_KARTE)->toString();
        } else {
            if ($reiseOld !== null && $reiseOld->getKarte() !== null) {
                $imageKartenBild = $reiseOld->getKarte()->toString();
            }
        }
        $object->karte = $imageKartenBild;

        /** @var null|Image $imageTeaserBild */
        $imageTeaserBild = null;
        if (Tools::getFile('teaserBild') !== false) {
            $imageTeaserBild = Image::fromUploadWithSave(Tools::getFile('teaserBild'), Image::USE_TEASER)->toString();
        } else {
            if ($reiseOld !== null && $reiseOld->getTeaser() !== null) {
                $imageTeaserBild = $reiseOld->getTeaser()->toString();
            }
        }
        $object->teaser = $imageTeaserBild;

        $reiseService = new ReiseService($this->database);
        $regionService = new RegionService($this->database);

        return $reiseService->getReiseByParams($object, $regionService);
    }

    public function bearbeiteReiseFormAction(): void
    {
        $parameter = [
            'notificationCode' => 'reiseEditError',
            'notificationStatus' => 'error',
            'reiseId' => Id::fromString(Tools::getValue('reiseId'))
        ];

        $reiseService = new ReiseService($this->database);

        $reiseId = Tools::getValue('reiseId');

        if (Tools::getValue('deleteReise') !== false) {
            $parameter = ['notificationCode' => 'reiseDeleteError', 'notificationStatus' => 'error'];

            if ($reiseService->deleteReiseByReiseId(Id::fromString($reiseId)) === true) {
                $parameter = ['notificationCode' => 'reiseDeleteSuccess', 'notificationStatus' => 'success'];
            }

            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
        }

        $editReise = null;
        if ($reiseId !== false) {
            $reiseId = Id::fromString($reiseId);
            $editReise = $reiseService->getCompleteReiseByReiseId($reiseId);
        }

        $reise = $this->getReiseFromParameter($editReise);

        if ($reise === null) {
            $regionService = new RegionService($this->database);

            $reise = $reiseService->getReiseVorschauByParameter((object)$_POST, $regionService);

            /** @var array $parameter */
            if ($reise !== null && $reiseService->saveReisevorschauToDatabase($reise) === true) {
                $parameter = [
                    'notificationCode' => 'reiseEditSuccess',
                    'notificationStatus' => 'success',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            } else {
                $parameter = [
                    'notificationCode' => 'reiseEditError',
                    'notificationStatus' => 'error',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            }
        } else {
            if ($reiseService->saveReiseToDatabase($reise) === true) {
                $parameter = [
                    'notificationCode' => 'reiseEditSuccess',
                    'notificationStatus' => 'success',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            }
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    public function erstelleNeuigkeitenAction(): void
    {
        $newsService = new NewsService($this->database);

        $news = $newsService->getNewsByParams($_POST);

        /** @var array $parameter */
        $parameter = ['notificationCode' => 'newsInsertError', 'notificationStatus' => 'error'];
        if ($newsService->saveNewsToDatabase($news) === true) {
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

    public function bearbeiteFrageFormAction(): void
    {
        $parameter = [
            'notificationCode' => 'frageError',
            'notificationStatus' => 'error',
            'reiseId' => Id::fromString(Tools::getValue('reiseId'))
        ];

        $frageService = new FrageService($this->database);

        if (Tools::getValue('frageDelete') !== false) {
            if ($frageService->deleteFrageByFrageId(Id::fromString(Tools::getValue('frageId'))) === true) {
                $parameter = [
                    'notificationCode' => 'frageSuccess',
                    'notificationStatus' => 'success',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            }

            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        $frage = $frageService->getFrageByParams($_POST);

        if ($frage === null) {
            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        if ($frageService->saveFrageToDatabase($frage) === true) {
            $parameter = [
                'notificationCode' => 'frageSuccess',
                'notificationStatus' => 'success',
                'reiseId' => Id::fromString(Tools::getValue('reiseId'))
            ];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    public function bearbeiteReiseverlaufFormAction(): void
    {
        $parameter = [
            'notificationCode' => 'reiseverlaufError',
            'notificationStatus' => 'error',
            'reiseId' => Id::fromString(Tools::getValue('reiseId'))
        ];

        $reiseverlaufService = new ReiseverlaufService($this->database);

        if (Tools::getValue('loescheReiseverlauf') !== false) {
            if ($reiseverlaufService->deleteReiseverlaufByReiseverlaufId(Id::fromString(Tools::getValue('reiseverlaufId'))) === true) {
                $parameter = [
                    'notificationCode' => 'reiseverlaufSuccess',
                    'notificationStatus' => 'success',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            }

            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        $reiseverlauf = $reiseverlaufService->getReiseverlaufByParams($_POST);

        if ($reiseverlauf === null) {
            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        if ($reiseverlaufService->saveReiseverlaufToDatabase($reiseverlauf) === true) {
            $parameter = [
                'notificationCode' => 'reiseverlaufSuccess',
                'notificationStatus' => 'success',
                'reiseId' => Id::fromString(Tools::getValue('reiseId'))
            ];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }

    public function bearbeiteTerminFormAction(): void
    {
        $parameter = [
            'notificationCode' => 'temrinError',
            'notificationStatus' => 'error',
            'reiseId' => Id::fromString(Tools::getValue('reiseId'))
        ];

        $terminService = new TerminService($this->database);

        if (Tools::getValue('loescheTermin') !== false) {
            if ($terminService->deleteTerminByTerminId(Id::fromString(Tools::getValue('terminId'))) === true) {
                $parameter = [
                    'notificationCode' => 'terminSuccess',
                    'notificationStatus' => 'success',
                    'reiseId' => Id::fromString(Tools::getValue('reiseId'))
                ];
            }

            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        $termin = $terminService->getTerminByParams($_POST);

        if ($termin === null) {
            header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
            exit;
        }

        if ($terminService->saveTerminToDatabase($termin) === true) {
            $parameter = [
                'notificationCode' => 'terminSuccess',
                'notificationStatus' => 'success',
                'reiseId' => Id::fromString(Tools::getValue('reiseId'))
            ];
        }

        header('Location: ' . Tools::getRouteUrl('loggedin', $parameter));
    }
}