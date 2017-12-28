<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;

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
        // News for template
        $this->getNews();

        // Reisen for Template
        $this->getReisenContainer(true);

        $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('page/home.twig'));

        $this->jsonModel->send();
    }
}