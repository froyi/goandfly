<?php declare(strict_types=1);

namespace Project\Module\Reise;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\Flugzeit;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Personen;
use Project\Module\GenericValueObject\Price;
use Project\Module\GenericValueObject\Reisedauer;
use Project\Module\GenericValueObject\Terrain;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;
use Project\Module\Leistung\Leistung;
use Project\Module\Region\Region;
use Project\Module\Tag\Tag;

class Reisevorschau
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

    /** @var  array $regionList */
    protected $regionList = [];

    /** @var array $tagListe */
    protected $tagListe = [];

    /** @var array $terminListe */
    protected $terminListe = [];

    /** @var array $reiseverlaufListe */
    protected $reiseverlaufListe = [];

    /** @var Leistung $leistung */
    protected $leistung;

    /** @var array $frageListe */
    protected $frageListe = [];

    /** @var null|Price */
    protected $preisAb;

    public function __construct(Id $reiseId, Datetime $bearbeitet, Date $sichtbar)
    {
        $this->reiseId = $reiseId;
        $this->bearbeitet = $bearbeitet;
        $this->sichtbar = $sichtbar;
    }

    /**
     * @return array
     */
    public function getRegionList(): array
    {
        return $this->regionList;
    }

    /**
     * @param array $regionList
     */
    public function setRegionList(array $regionList): void
    {
        $this->regionList = $regionList;
    }

    /**
     * @param Region $region
     */
    public function addRegionToRegionList(Region $region): void
    {
        $this->regionList[$region->getRegionId()->toString()] = $region;
    }

    /**
     * @return array
     */
    public function getFrageListe(): array
    {
        return $this->frageListe;
    }

    /**
     * @param array $frageListe
     */
    public function setFrageListe(array $frageListe)
    {
        $this->frageListe = $frageListe;
    }

    /**
     * @return array
     */
    public function getLeistung(): ?Leistung
    {
        return $this->leistung;
    }

    /**
     * @param array $leistungListe
     */
    public function setLeistung(Leistung $leistungListe)
    {
        $this->leistung = $leistungListe;
    }

    /**
     * @return array
     */
    public function getReiseverlaufListe(): array
    {
        return $this->reiseverlaufListe;
    }

    /**
     * @param array $reiseverlaufListe
     */
    public function setReiseverlaufListe(array $reiseverlaufListe)
    {
        $this->reiseverlaufListe = $reiseverlaufListe;
    }

    /**
     * @return array
     */
    public function getTerminListe(): array
    {
        return $this->terminListe;
    }

    /**
     * @param array $terminListe
     */
    public function setTerminListe(array $terminListe)
    {
        $this->terminListe = $terminListe;
    }

    /**
     * @return array
     */
    public function getTagListe(): array
    {
        return $this->tagListe;
    }

    /**
     * @param array $tagListe
     */
    public function setTagToTagListe(Tag $tag): void
    {
        $this->tagListe[$tag->getTagId()->toString()] = $tag;
    }

    /**
     *
     */
    public function resetTagListe(): void
    {
        $this->tagListe = [];
    }

    /**
     * @param array $tagListe
     */
    public function setTagListeToTagListe(array $tagListe): void
    {
        $this->tagListe = $tagListe;
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
    public function getKurzbeschreibung(): ?Text
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
    public function getBeschreibung(): ?Text
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
    public function getTitel(): ?Title
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
    public function getPersonen(): ?Personen
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
    public function getReisedauer(): ?Reisedauer
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
    public function getFlugzeit(): ?Flugzeit
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
    public function getSprache(): ?Text
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
    public function getTerrain(): ?Terrain
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
    public function getKarte(): ?Image
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
    public function getTeaser(): ?Image
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
    public function getBild(): ?Image
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
    public function getVeranstalter(): ?Name
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

    /**
     * @param Price $preisAb
     */
    public function setPreisAb(Price $preisAb): void
    {
        $this->preisAb = $preisAb;
    }

    /**
     * @return Price|null
     */
    public function getPreisAb(): ?Price
    {
        return $this->preisAb;
    }
}