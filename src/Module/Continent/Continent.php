<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Text;
use Project\Module\Region\Region;

/**
 * Class Continent
 * @package Project\Module\Continent
 */
class Continent
{
    /** @var Id $continentId */
    protected $continentId;

    /** @var Name $name */
    protected $name;

    /** @var Text $flaeche */
    protected $flaeche;

    /** @var Text $gliederung */
    protected $gliederung;

    /** @var Text $tourismus */
    protected $tourismus;

    /** @var Text $klima */
    protected $klima;

    /** @var Image */
    protected $bild;

    /** @var array $regionList */
    protected $regionList = [];

    /**
     * Continent constructor.
     * @param Id $id
     * @param Name $name
     * @param Text $flaeche
     * @param Text $gliederung
     * @param Text $tourismus
     * @param Text $klima
     * @param Image $bild
     */
    public function __construct(Id $continentId, Name $name, Text $flaeche, Text $gliederung, Text $tourismus, Text $klima, Image $bild)
    {
        $this->continentId = $continentId;
        $this->name = $name;
        $this->flaeche = $flaeche;
        $this->gliederung = $gliederung;
        $this->tourismus = $tourismus;
        $this->klima = $klima;
        $this->bild = $bild;
    }

    /**
     * @return Id
     */
    public function getContinentId(): Id
    {
        return $this->continentId;
    }

    /**
     * @return Text
     */
    public function getFlaeche(): Text
    {
        return $this->flaeche;
    }

    /**
     * @return Text
     */
    public function getGliederung(): Text
    {
        return $this->gliederung;
    }

    /**
     * @return Text
     */
    public function getTourismus(): Text
    {
        return $this->tourismus;
    }

    /**
     * @return Text
     */
    public function getKlima(): Text
    {
        return $this->klima;
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
     * @param Text $flaeche
     */
    public function setFlaeche(Text $flaeche): void
    {
        $this->flaeche = $flaeche;
    }

    /**
     * @param Text $gliederung
     */
    public function setGliederung(Text $gliederung): void
    {
        $this->gliederung = $gliederung;
    }

    /**
     * @param Text $tourismus
     */
    public function setTourismus(Text $tourismus): void
    {
        $this->tourismus = $tourismus;
    }

    /**
     * @param Text $klima
     */
    public function setKlima(Text $klima): void
    {
        $this->klima = $klima;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name): void
    {
        $this->name = $name;
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
    public function getRegionList(): array
    {
        return $this->regionList;
    }

    /**
     * reset the region list
     */
    public function resetRegionList(): void
    {
        $this->regionList = [];
    }
}