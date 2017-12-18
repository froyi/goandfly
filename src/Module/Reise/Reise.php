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
class Reise
{
    /** @var Id $reiseId */
    protected $reiseId;

    /** @var Text $kurzbeschreibung */
    protected $kurzbeschreibung;

    /** @var Text $beschreibung */
    protected $beschreibung;

    /** @var Title $titel */
    protected $titel;

    /** @var Personen $personen */
    protected $personen;

    /** @var Reisedauer $reisedauer */
    protected $reisedauer;

    /** @var Flugzeit $flugzeit */
    protected $flugzeit;

    /** @var Text $sprache */
    protected $sprache;

    /** @var Terrain $terrain */
    protected $terrain;

    /** @var Image $karte */
    protected $karte;

    /** @var Datetime */
    protected $bearbeitet;

    /** @var Image $teaser */
    protected $teaser;

    /** @var Date */
    protected $sichtbar;

    /** @var Image $bild */
    protected $bild;

    /** @var Name $veranstalter */
    protected $veranstalter;

    public function __construct(Id $reiseId, Text $kurzbeschreibung, Text $beschreibung, Title $titel, Personen $personen, Reisedauer $reisedauer, Flugzeit $flugzeit, Text $sprache, Terrain $terrain, Image $karte, Datetime $bearbeitet, Image $teaser, Date $sichtbar, Image $bild, Name $veranstalter)
    {
        $this->reiseId = $reiseId;
        $this->kurzbeschreibung = $kurzbeschreibung;
        $this->beschreibung = $beschreibung;
        $this->titel = $titel;
        $this->personen = $personen;
        $this->reisedauer = $reisedauer;
        $this->flugzeit = $flugzeit;
        $this->sprache = $sprache;
        $this->terrain = $terrain;
        $this->karte = $karte;
        $this->bearbeitet = $bearbeitet;
        $this->teaser = $teaser;
        $this->sichtbar = $sichtbar;
        $this->bild = $bild;
        $this->veranstalter = $veranstalter;
    }

    /**
     * @return Id
     */
    public function getReiseId(): Id
    {
        return $this->reiseId;
    }

    /**
     * @return Text
     */
    public function getKurzbeschreibung(): Text
    {
        return $this->kurzbeschreibung;
    }

    /**
     * @param Text $kurzbeschreibung
     */
    public function setKurzbeschreibung(Text $kurzbeschreibung): void
    {
        $this->kurzbeschreibung = $kurzbeschreibung;
    }

    /**
     * @return Text
     */
    public function getBeschreibung(): Text
    {
        return $this->beschreibung;
    }

    /**
     * @param Text $beschreibung
     */
    public function setBeschreibung(Text $beschreibung): void
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @return Title
     */
    public function getTitel(): Title
    {
        return $this->titel;
    }

    /**
     * @param Title $titel
     */
    public function setTitel(Title $titel): void
    {
        $this->titel = $titel;
    }

    /**
     * @return Personen
     */
    public function getPersonen(): Personen
    {
        return $this->personen;
    }

    /**
     * @param Personen $personen
     */
    public function setPersonen(Personen $personen): void
    {
        $this->personen = $personen;
    }

    /**
     * @return Reisedauer
     */
    public function getReisedauer(): Reisedauer
    {
        return $this->reisedauer;
    }

    /**
     * @param Reisedauer $reisedauer
     */
    public function setReisedauer(Reisedauer $reisedauer): void
    {
        $this->reisedauer = $reisedauer;
    }

    /**
     * @return Flugzeit
     */
    public function getFlugzeit(): Flugzeit
    {
        return $this->flugzeit;
    }

    /**
     * @param Flugzeit $flugzeit
     */
    public function setFlugzeit(Flugzeit $flugzeit): void
    {
        $this->flugzeit = $flugzeit;
    }

    /**
     * @return Text
     */
    public function getSprache(): Text
    {
        return $this->sprache;
    }

    /**
     * @param Text $sprache
     */
    public function setSprache(Text $sprache): void
    {
        $this->sprache = $sprache;
    }

    /**
     * @return Terrain
     */
    public function getTerrain(): Terrain
    {
        return $this->terrain;
    }

    /**
     * @param Terrain $terrain
     */
    public function setTerrain(Terrain $terrain): void
    {
        $this->terrain = $terrain;
    }

    /**
     * @return Image
     */
    public function getKarte(): Image
    {
        return $this->karte;
    }

    /**
     * @param Image $karte
     */
    public function setKarte(Image $karte): void
    {
        $this->karte = $karte;
    }

    /**
     * @return Datetime
     */
    public function getBearbeitet(): Datetime
    {
        return $this->bearbeitet;
    }

    /**
     * @param Datetime $bearbeitet
     */
    public function setBearbeitet(Datetime $bearbeitet): void
    {
        $this->bearbeitet = $bearbeitet;
    }

    /**
     * @return Image
     */
    public function getTeaser(): Image
    {
        return $this->teaser;
    }

    /**
     * @param Image $teaser
     */
    public function setTeaser(Image $teaser): void
    {
        $this->teaser = $teaser;
    }

    /**
     * @return Date
     */
    public function getSichtbar(): Date
    {
        return $this->sichtbar;
    }

    /**
     * @param Date $sichtbar
     */
    public function setSichtbar(Date $sichtbar): void
    {
        $this->sichtbar = $sichtbar;
    }

    /**
     * @return Image
     */
    public function getBild(): Image
    {
        return $this->bild;
    }

    /**
     * @param Image $bild
     */
    public function setBild(Image $bild): void
    {
        $this->bild = $bild;
    }

    /**
     * @return Name
     */
    public function getVeranstalter(): Name
    {
        return $this->veranstalter;
    }

    /**
     * @param Name $veranstalter
     */
    public function setVeranstalter(Name $veranstalter): void
    {
        $this->veranstalter = $veranstalter;
    }

}