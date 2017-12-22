<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Continent\ContinentService;
use Project\Module\Database\Database;
use Project\Module\Region\RegionService;
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
    }

    protected function setDefaultData(): void
    {
        $regionService = new RegionService($this->database);
        $this->viewRenderer->addViewConfig('regions', $regionService->getAllRegions());

        $continentService = new ContinentService($this->database);
        $this->viewRenderer->addViewConfig('continents', $continentService->getAllContinentsWithRegionList($regionService));
    }

    /**
     * not found action
     * @throws \Twig_Error_Syntax
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Runtime
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

    /**
     * error action
     * @throws \Twig_Error_Runtime
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Loader
     */
    public function errorPageAction(): void
    {
        $this->showStandardPage('error');
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
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
}