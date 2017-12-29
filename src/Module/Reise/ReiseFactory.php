<?php
declare (strict_types=1);

namespace Project\Module\Reise;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\Flugzeit;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Personen;
use Project\Module\GenericValueObject\Reisedauer;
use Project\Module\GenericValueObject\Terrain;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;

/**
 * Class ReiseFactory
 * @package Project\Module\Reise
 */
class ReiseFactory
{
    /**
     * @param $object
     * @return Reise
     */
    public function getReiseFromObject($object): Reise
    {
        $reiseId = Id::fromString($object->reiseId);
        $kurzbeschreibung = Text::fromString($object->kurzbeschreibung);
        $beschreibung = Text::fromString($object->beschreibung);
        $titel = Title::fromString($object->titel);
        $personen = Personen::fromValue($object->personen);
        $reisedauer = Reisedauer::fromValue((int)$object->reisedauer);
        $flugzeit = Flugzeit::fromValue((int)$object->flugzeit);
        $sprache = Text::fromString($object->sprache);
        $terrain = Terrain::fromValue((int)$object->terrain);
        $karte = Image::fromFile($object->karte);
        $bearbeitet = Datetime::fromValue($object->bearbeitet);
        $teaser = Image::fromFile($object->teaser);
        $sichtbar = Date::fromValue($object->sichtbar);
        $bild = Image::fromFile($object->bild);
        $veranstalter = Name::fromString($object->veranstalter);

        return new Reise($reiseId, $kurzbeschreibung, $beschreibung, $titel, $personen, $reisedauer, $flugzeit, $sprache, $terrain, $karte, $bearbeitet, $teaser, $sichtbar, $bild, $veranstalter);
    }

    /**
     * @param $object
     *
     * @return Reiseveranstalter
     */
    public function getVeranstalterFromObject($object): Reiseveranstalter
    {
        $name = Name::fromString($object->veranstalter);

        return new Reiseveranstalter($name);
    }
}