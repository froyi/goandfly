<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;

use Project\Module\Continent\Continent;
use Project\Module\Continent\ContinentService;
use Project\Module\GenericValueObject\Id;
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
    public function __construct(Configuration $configuration)
    {
        parent::__construct($configuration);

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
}