<?php
declare (strict_types=1);

namespace Project\Module\Migration;

use Project\Module\Database\Database;
use Project\Module\Database\Query;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\GenericValueObject\PasswordHash;

class Migrate
{
    /** @var Database $newDatabase */
    protected $newDatabase;

    /** @var Database $oldDatabase */
    protected $oldDatabase;

    protected $tagArray = [];

    protected $continentArray = [];

    protected $errors = [];

    protected $regionArray = [];

    public function __construct(Database $oldDatabase, Database $newDatabase)
    {
        $this->oldDatabase = $oldDatabase;
        $this->newDatabase = $newDatabase;
    }

    public function migrate(): void
    {
        $this->emptyDatabase();

        $this->migrateContinent();

        $this->migrateRegion();

        $this->migrateNeuigkeiten();

        $this->migrateTeaserbild();

        $this->migrateUser();

        $this->migrateTags();

        $this->migrateReise();

        $this->showError();
    }

    protected function emptyDatabase()
    {
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('user'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('termin'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('teaserbild'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('tag'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('reise_tag'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('reise_region'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('reiseverlauf'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('reise'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('region'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('neuigkeiten'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('leistung'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('frage'));
        $this->newDatabase->execute($this->newDatabase->getNewTruncatQuery('continent'));
    }

    protected function migrateContinent(): void
    {
        $table_old = 'kontinente';
        $table_new = 'continent';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $oldContinentId = $singleData->id;

            $id = Id::generateId()->toString();
            $name = html_entity_decode(utf8_encode($singleData->name));
            $flaeche = html_entity_decode(utf8_encode($singleData->flaeche));
            $gliederung = html_entity_decode(utf8_encode($singleData->gliederung));
            $tourismus = html_entity_decode(utf8_encode($singleData->tourismus));
            $klima = html_entity_decode(utf8_encode($singleData->klima));
            $bild = 'data/img/continent/' . $singleData->bild;

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('continentId', $id);
            $query->insert('name', $name);
            $query->insert('flaeche', $flaeche);
            $query->insert('gliederung', $gliederung);
            $query->insert('tourismus', $tourismus);
            $query->insert('klima', $klima);
            $query->insert('bild', $bild);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }

            $this->continentArray[$oldContinentId] = $id;
        }
    }

    protected function migrateRegion(): void
    {
        $table_old = 'region';
        $table_new = 'region';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $oldRegionId = $singleData->id;
            $id = Id::generateId()->toString();
            $continentId = $this->continentArray[$singleData->kontinente_id];
            $name = html_entity_decode(utf8_encode($singleData->titel));
            $beispiellaender = html_entity_decode(utf8_encode($singleData->beispiellaender));
            $beschreibung = str_replace('\'', '`', html_entity_decode(utf8_encode($singleData->beschreibung)));
            $bild = 'data/img/region/' . $singleData->bild;

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('regionId', $id);
            $query->insert('continentId', $continentId);
            $query->insert('name', $name);
            $query->insert('beispiellaender', $beispiellaender);
            $query->insert('beschreibung', $beschreibung);
            $query->insert('bild', $bild);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }

            $this->regionArray[$oldRegionId] = $id;
        }
    }

    protected function migrateNeuigkeiten(): void
    {
        $table_old = 'neuigkeiten';
        $table_new = 'neuigkeiten';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $titel = html_entity_decode($singleData->titel);
            $datum = html_entity_decode(utf8_encode($singleData->datum));
            $text = $singleData->text;

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('newsId', $id);
            $query->insert('titel', $titel);
            $query->insert('datum', $datum);
            $query->insert('text', $text);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateTeaserbild(): void
    {
        $table_old = 'teaser';
        $table_new = 'teaserbild';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $pfad = html_entity_decode($singleData->pfad);

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('teaserbildId', $id);
            $query->insert('teaserbild', $pfad);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateUser(): void
    {
        $table_old = 'user';
        $table_new = 'user';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $email = $singleData->email;
            $passwordHash = PasswordHash::fromPassword(Password::fromString('dieterrosenbusch'))->getPassword();

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('userId', $id);
            $query->insert('email', $email);
            $query->insert('passwordHash', $passwordHash);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateTags(): void
    {
        $table_old = 'tags';
        $table_new = 'tag';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $oldTagId = $singleData->id;

            $id = Id::generateId()->toString();
            $name = html_entity_decode(utf8_encode($singleData->name));

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('tagId', $id);
            $query->insert('name', $name);
            $query->insert('position', $oldTagId);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }

            $this->tagArray[$oldTagId] = $id;
        }
    }

    protected function migrateReise(): void
    {
        $table_old = 'reise';
        $table_new = 'reise';

        $data = $this->oldDatabase->fetchAll($this->oldDatabase->getNewSelectQuery($table_old));

        foreach ($data as $singleData) {
            $oldReiseId = $singleData->id;

            $id = Id::generateId()->toString();
            $kurzbeschreibung = str_replace('\'', '`', html_entity_decode($singleData->kurzbeschreibung));
            $beschreibung = str_replace('\'', '`', html_entity_decode($singleData->beschreibung));
            $titel = str_replace('\'', '`', html_entity_decode($singleData->titel));
            $personen = html_entity_decode(utf8_encode($singleData->personen));
            $reisedauer = (int)$singleData->zeit;
            $flugzeit = (int)$singleData->flug;
            $sprache = $singleData->sprache;
            $terrain = (int)$singleData->terrain;
            if ($terrain < 1) {
                $terrain = 1;
            }
            $karte = $singleData->karte;
            $bearbeitet = $singleData->eingestellt;
            $teaser = $singleData->teaser;

            $sichtbar = $singleData->sichtbar;
            if ($singleData->sichtbar === '0000-00-00') {
                $sichtbar = '2020-12-31';
            }

            $bild = $singleData->bild;
            $veranstalter = html_entity_decode(utf8_encode($singleData->veranstalter));

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('reiseId', $id);
            $query->insert('kurzbeschreibung', $kurzbeschreibung);
            $query->insert('beschreibung', $beschreibung);
            $query->insert('titel', $titel);
            $query->insert('personen', $personen);
            $query->insert('reisedauer', $reisedauer);
            $query->insert('flugzeit', $flugzeit);
            $query->insert('sprache', $sprache);
            $query->insert('terrain', $terrain);
            $query->insert('karte', $karte);
            $query->insert('bearbeitet', $bearbeitet);
            $query->insert('teaser', $teaser);
            $query->insert('sichtbar', $sichtbar);
            $query->insert('bild', $bild);
            $query->insert('veranstalter', $veranstalter);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }

            $this->migrateTermin($id, $oldReiseId);
            $this->migrateReiseTag($id, $oldReiseId);
            $this->migrateFrage($id, $oldReiseId);
            $this->migrateLeistung($id, $oldReiseId);
            $this->migrateReiseverlauf($id, $oldReiseId);
            $this->migrateReiseRegion($id, $oldReiseId);
        }
    }

    protected function migrateTermin($reiseId, $oldReiseId): void
    {
        $table_old = 'termine';
        $table_new = 'termin';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);

        $data = $this->oldDatabase->fetchAll($query);

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $start = $singleData->start;
            $ende = $singleData->ende;
            if ($singleData->ende === '0000-00-00' || $singleData->ende === '2017-00-00') {
                $ende = '2017-12-31';
            }

            $preis = $singleData->preis;

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('terminId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('start', $start);
            $query->insert('ende', $ende);
            $query->insert('preis', $preis);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateReiseTag($reiseId, $oldReiseId): void
    {
        $table_old = 'reise_tags';
        $table_new = 'reise_tag';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);

        $data = $this->oldDatabase->fetchAll($query);

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $tagId = $this->tagArray[$singleData->tags_id];

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('reiseTagId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('tagId', $tagId);

            $this->newDatabase->execute($query);
        }

        /*$query = $this->newDatabase->getNewSelectQuery($table_new);
         var_dump($this->newDatabase->fetchAll($query));*/
    }

    protected function migrateFrage($reiseId, $oldReiseId): void
    {
        $table_old = 'fragen';
        $table_new = 'frage';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);

        $data = $this->oldDatabase->fetchAll($query);

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $frage = str_replace('\'', '`', $singleData->frage);
            $antwort = str_replace('\'', '`', $singleData->antwort);

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('frageId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('frage', $frage);
            $query->insert('antwort', $antwort);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateLeistung($reiseId, $oldReiseId): void
    {
        $table_old = 'leistungen';
        $table_new = 'leistung';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);

        $data = $this->oldDatabase->fetchAll($query);

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $text = html_entity_decode(utf8_encode($singleData->text));

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('leistungId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('text', $text);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function migrateReiseverlauf($reiseId, $oldReiseId): void
    {
        $table_old = 'reiseverlauf';
        $table_new = 'reiseverlauf';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);
        $query->orderBy('id', Query::ASC);

        $data = $this->oldDatabase->fetchAll($query);

        $tagReihe = 1;
        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $titel = str_replace('\'', '`', $singleData->titel);
            $beschreibung = str_replace('\'', '`', $singleData->beschreibung);

            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('reiseverlaufId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('reisetag', $tagReihe);
            $query->insert('titel', $titel);
            $query->insert('beschreibung', $beschreibung);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }

            $tagReihe++;
        }
    }

    protected function migrateReiseRegion($reiseId, $oldReiseId): void
    {
        $table_old = 'reise_region';
        $table_new = 'reise_region';

        $query = $this->oldDatabase->getNewSelectQuery($table_old);
        $query->where('reise_id', '=', $oldReiseId);

        $data = $this->oldDatabase->fetchAll($query);

        foreach ($data as $singleData) {
            $id = Id::generateId()->toString();
            $regionId = $this->regionArray[$singleData->region_id];
            $query = $this->newDatabase->getNewInsertQuery($table_new);

            $query->insert('reiseRegionId', $id);
            $query->insert('reiseId', $reiseId);
            $query->insert('regionId', $regionId);

            if ($this->newDatabase->execute($query) === false) {
                $this->errors[] = $query;
            }
        }
    }

    protected function showError()
    {
        echo 'ERROR <br/>';
        echo '------------------------------------------------------------------------------------------ <br/><br/>';

        /** @var Query $error */
        foreach ($this->errors as $error) {
            echo $error->getTables() . '<br/>';
            echo $error->getQuery() . '<br/>';
            echo '------------------------------------------------------------------------------------------ <br/><br>';
        }
    }
}