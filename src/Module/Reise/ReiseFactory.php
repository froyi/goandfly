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
     *
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

        return new Reise($reiseId, $kurzbeschreibung, $beschreibung, $titel, $personen, $reisedauer, $flugzeit,
            $sprache, $terrain, $karte, $bearbeitet, $teaser, $sichtbar, $bild, $veranstalter);
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

    /**
     *
     *
     * @param $object
     *
     * @return bool
     */
    public function validateObject($object): bool
    {
        try {
            if ($this->getReiseFromObject($object) === null) {
                return false;
            }
        } catch (\InvalidArgumentException $error) {
            return false;
        } catch (\TypeError $error) {
            return false;
        }

        return true;
    }

    /**
     *
     *
     * @param $object
     *
     * @return null|Reisevorschau
     */
    public function getReiseVorschauFromObject($object, ?bool $backend = false): ?Reisevorschau
    {
        $reiseId = Id::fromString($object->reiseId);
        $bearbeitet = Datetime::fromValue($object->bearbeitet);
        $sichtbar = Date::fromValue($object->sichtbar);

        if ($sichtbar->isPast() === false && $backend === false) {
            return null;
        }


        $reisevorschau = new Reisevorschau($reiseId, $bearbeitet, $sichtbar);

        if (!empty($object->kurzbeschreibung)) {
            $reisevorschau->setKurzbeschreibung(Text::fromString($object->kurzbeschreibung));
        }

        if (!empty($object->titel)) {
            $reisevorschau->setTitel(Title::fromString($object->titel));
        }

        if (!empty($object->personen)) {
            $reisevorschau->setPersonen(Personen::fromValue($object->personen));
        }

        if (!empty($object->reisedauer)) {
            $reisevorschau->setReisedauer(Reisedauer::fromValue((int)$object->reisedauer));
        }

        if (!empty($object->flugzeit)) {
            $reisevorschau->setFlugzeit(Flugzeit::fromValue((int)$object->flugzeit));
        }

        if (!empty($object->sprache)) {
            $reisevorschau->setSprache(Text::fromString($object->sprache));
        }

        if (!empty($object->terrain)) {
            $reisevorschau->setTerrain(Terrain::fromValue((int)$object->terrain));
        }

        if (!empty($object->karte)) {
            $reisevorschau->setKarte(Image::fromFile($object->karte));
        }

        if (!empty($object->teaser)) {
            $reisevorschau->setTeaser(Image::fromFile($object->teaser));
        }

        if (!empty($object->bild)) {
            $reisevorschau->setBild(Image::fromFile($object->bild));
        }

        if (!empty($object->veranstalter)) {
            $reisevorschau->setVeranstalter(Name::fromString($object->veranstalter));
        }

        return $reisevorschau;
    }

    /**
     *
     *
     * @param $object
     *
     * @return bool
     */
    public function validateReisevorschauObject($object, ?bool $backend = false): bool
    {
        try {
            if ($this->getReiseVorschauFromObject($object, $backend) === null) {
                return false;
            }
        } catch (\InvalidArgumentException $error) {
            return false;
        }

        return true;
    }
}