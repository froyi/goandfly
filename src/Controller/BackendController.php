<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Migration\Migrate;
use Project\Module\Region\RegionService;
use Project\Module\Reise\ReiseService;

/**
 * Class BackendController
 * @package Project\Controller
 */
class BackendController extends DefaultController
{
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

        $this->viewRenderer->addViewConfig('page', 'loggedin');
        $this->viewRenderer->renderTemplate();
    }
}