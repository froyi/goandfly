<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;

use Project\Module\Continent\Continent;
use Project\Module\Continent\ContinentService;
use Project\Module\Frage\FrageService;
use Project\Module\GenericValueObject\Id;
use Project\Module\Leistung\LeistungService;
use Project\Module\News\NewsService;
use Project\Module\Reise\ReiseService;
use Project\Module\Reiseverlauf\ReiseverlaufService;
use Project\Module\Tag\TagService;
use Project\Module\Termin\TerminService;
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
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        parent::__construct($configuration, $routeName);

        $this->jsonModel = new JsonModel();
    }

    public function filterReisenAction()
    {
        // News for template
        $this->getNews();

        // Reisen for Template
        $this->getReisenContainer(true);

        $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('page/home.twig'));

        $this->jsonModel->send();
    }

    public function navigationRegionsAction()
    {
        $this->viewRenderer->addViewConfig('continent', $this->getContinentData());

        $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('partial/region_ausgabe.twig'));

        $this->jsonModel->send();
    }

    /**
     * @return null|Continent
     */
    protected function getContinentData(): ?Continent
    {
        $continentId = Tools::getValue('continentId');

        if ($continentId === false) {
            $this->jsonModel->send('error');
        }

        $continentId = Id::fromString($continentId);

        $continentService = new ContinentService($this->database);

        return $continentService->getContinentByContinentId($continentId);
    }

    public function bearbeiteNeuigkeitenAction()
    {
        $newsId = Tools::getValue('newsId');

        if ($newsId === false) {
            $this->jsonModel->send('error');
        }

        $newsId = Id::fromString($newsId);

        $newsService = new NewsService($this->database);

        $news = $newsService->getNewsByNewsId($newsId);

        if ($news === null) {
            $this->jsonModel->send('error');
        }

        $this->viewRenderer->addViewConfig('bearbeiteNews', $news);

        $this->jsonModel->addJsonConfig('view',
            $this->viewRenderer->renderJsonView('partial/bearbeite_neuigkeiten.twig'));
        $this->jsonModel->send();
    }

    public function bearbeiteReiseAction(): void
    {
        $reiseId = Tools::getValue('reiseId');

        if ($reiseId === false) {
            $this->jsonModel->send('error');
        }

        $reiseId = Id::fromString($reiseId);

        $reiseService = new ReiseService($this->database);

        $reise = $reiseService->getCompleteReiseByReiseId($reiseId);

        $this->viewRenderer->addViewConfig('bearbeiteReise', $reise);

        $this->getTagListe();

        $this->jsonModel->addJsonConfig('view',
            $this->viewRenderer->renderJsonView('partial/bearbeite_reise.twig'));
        $this->jsonModel->send();
    }

    public function erstelleFrageAction(): void
    {
        $frageService = new FrageService($this->database);

        $frage = $frageService->getFrageByParams($_POST);

        if ($frage === null) {
            $this->jsonModel->send('error');
        }

        if ($frageService->saveFrageToDatabase($frage) === true) {
            $this->jsonModel->addJsonConfig('frage', $frage);
            $this->jsonModel->send();
        }

        $this->jsonModel->send('error');
    }

    public function bearbeiteFrageAction(): void
    {
        $frageId = Tools::getValue('frageId');

        if ($frageId === false) {
            $this->jsonModel->send('error');
        }

        $frageService = new FrageService($this->database);

        $frage = $frageService->getFrageByFrageId(Id::fromString($frageId));

        $this->viewRenderer->addViewConfig('bearbeiteFrage', $frage);

        $this->jsonModel->addJsonConfig('view',
            $this->viewRenderer->renderJsonView('partial/bearbeite_frage.twig'));
        $this->jsonModel->send();
    }

    public function erstelleLeistungenAction(): void
    {
        $leistungService = new LeistungService($this->database);

        $leistung = $leistungService->getLeistungByParams($_POST);

        if ($leistung === null) {
            $this->jsonModel->send('error');
        }

        if ($leistungService->saveLeistungToDatabase($leistung) === true) {
            $this->jsonModel->addJsonConfig('leistung', $leistung);
            $this->jsonModel->send();
        }

        $this->jsonModel->send('error');
    }

    public function erstelleReiseverlaufAction(): void
    {
        $reiseverlaufService = new ReiseverlaufService($this->database);

        $reiseverlauf = $reiseverlaufService->getReiseverlaufByParams($_POST);

        if ($reiseverlauf === null) {
            $this->jsonModel->send('error');
        }

        if ($reiseverlaufService->saveReiseverlaufToDatabase($reiseverlauf) === true) {
            $this->jsonModel->addJsonConfig('reiseverlauf', $reiseverlauf);
            $this->jsonModel->send();
        }

        $this->jsonModel->send('error');
    }

    public function bearbeiteReiseverlaufAction(): void
    {
        $reiseverlaufId = Tools::getValue('reiseverlaufId');

        if ($reiseverlaufId === false) {
            $this->jsonModel->send('error');
        }

        $reiseverlaufService = new ReiseverlaufService($this->database);

        $reiseverlauf = $reiseverlaufService->getReiseverlaufByReiseverlaufId(Id::fromString($reiseverlaufId));

        $this->viewRenderer->addViewConfig('bearbeiteReiseverlauf', $reiseverlauf);

        $this->jsonModel->addJsonConfig('view',
            $this->viewRenderer->renderJsonView('partial/bearbeite_reiseverlauf.twig'));
        $this->jsonModel->send();
    }

    public function erstelleReiseterminAction(): void
    {
        $terminService = new TerminService($this->database);

        $termin = $terminService->getTerminByParams($_POST);

        if ($termin === null) {
            $this->jsonModel->send('error');
        }

        if ($terminService->saveTerminToDatabase($termin) === true) {
            $this->jsonModel->addJsonConfig('termin', $termin);
            $this->jsonModel->send();
        }

        $this->jsonModel->send('error');
    }

    public function bearbeiteTerminAction(): void
    {
        $terminId = Tools::getValue('terminId');

        if ($terminId === false) {
            $this->jsonModel->send('error');
        }

        $terminService = new TerminService($this->database);

        $termin = $terminService->getTerminByTerminId(Id::fromString($terminId));

        $this->viewRenderer->addViewConfig('bearbeiteReisetermin', $termin);

        $this->jsonModel->addJsonConfig('view',
            $this->viewRenderer->renderJsonView('partial/bearbeite_reisetermin.twig'));
        $this->jsonModel->send();
    }

    public function erstelleTagAction(): void
    {
        if (Tools::getValue('reiseId') === false || Tools::getValue('tagIds') === false ) {
            $this->jsonModel->send('error');
        }

        $tagService = new TagService($this->database);

        $tags = $tagService->getTagsByTagIdArray(Tools::getValue('tagIds'));
        $reiseId = Id::fromString(Tools::getValue('reiseId'));

        if ($tagService->saveTagsToReiseInDatabase($tags, $reiseId) === true) {
            $this->jsonModel->addJsonConfig('tags', $tags);
            $this->jsonModel->send();
        }

        $this->jsonModel->send('error');
    }
}