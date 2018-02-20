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
 * Class Reise
 * @package Project\Module\Reise
 */
class Reise extends Reisevorschau
{
    /**
     * Reise constructor.
     *
     * @param Id         $reiseId
     * @param Text       $kurzbeschreibung
     * @param Text       $beschreibung
     * @param Title      $titel
     * @param Personen   $personen
     * @param Reisedauer $reisedauer
     * @param Flugzeit   $flugzeit
     * @param Text       $sprache
     * @param Terrain    $terrain
     * @param Image      $karte
     * @param Datetime   $bearbeitet
     * @param Image      $teaser
     * @param Date       $sichtbar
     * @param Image      $bild
     * @param Name       $veranstalter
     */
    public function __construct(Id $reiseId, Text $kurzbeschreibung, Text $beschreibung, Title $titel, Personen $personen, Reisedauer $reisedauer, Flugzeit $flugzeit, Text $sprache, Terrain $terrain, Image $karte, Datetime $bearbeitet, Image $teaser, Date $sichtbar, Image $bild, Name $veranstalter)
    {
        parent::__construct($reiseId, $bearbeitet, $sichtbar);

        $this->kurzbeschreibung = $kurzbeschreibung;
        $this->beschreibung = $beschreibung;
        $this->titel = $titel;
        $this->personen = $personen;
        $this->reisedauer = $reisedauer;
        $this->flugzeit = $flugzeit;
        $this->sprache = $sprache;
        $this->terrain = $terrain;
        $this->karte = $karte;
        $this->teaser = $teaser;
        $this->bild = $bild;
        $this->veranstalter = $veranstalter;
    }
}