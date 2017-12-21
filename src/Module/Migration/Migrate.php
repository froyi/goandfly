<?php
declare (strict_types=1);

namespace Project\Module\Migration;

use Project\Module\Database\Database;

class Migrate
{
    /** @var Database $newDatabase */
    protected $newDatabase;

    /** @var Database $oldDatabase */
    protected $oldDatabase;

    public function __construct(Database $oldDatabase, Database $newDatabase)
    {
        $this->oldDatabase = $oldDatabase;
        $this->newDatabase = $newDatabase;
    }

    public function migrate(): void
    {
        $this->emptyDatabase();
    }

    protected function emptyDatabase()
    {
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('tag'));
    }
}