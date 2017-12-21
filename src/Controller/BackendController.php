<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Migration\Migrate;

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
}