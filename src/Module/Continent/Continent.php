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

    /** @var Image $bild */
    protected $bild;

    /** @var  Image $categoryBild */
    protected $categoryBild;

    /** @var array $regionList */
    protected $regionList = [];

    /**
     * Continent constructor.
     *
     * @param Id $continentId
     * @param Name $name
     * @param Text $flaeche
     * @param Text $gliederung
     * @param Text $tourismus
     * @param Text $klima
     * @param Image $bild
     * @param Image $categoryBild
     *
     * @internal param Id $id
     */
    public function __construct(Id $continentId, Name $name, Text $flaeche, Text $gliederung, Text $tourismus, Text $klima, Image $bild, Image $categoryBild)
    {
        $this->continentId = $continentId;
        $this->name = $name;
        $this->flaeche = $flaeche;
        $this->gliederung = $gliederung;
        $this->tourismus = $tourismus;
        $this->klima = $klima;
        $this->bild = $bild;
        $this->categoryBild = $categoryBild;
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
     * @param Text $flaeche
     */
    public function setFlaeche(Text $flaeche): void
    {
        $this->flaeche = $flaeche;
    }

    /**
     * @return Text
     */
    public function getGliederung(): Text
    {
        return $this->gliederung;
    }

    /**
     * @param Text $gliederung
     */
    public function setGliederung(Text $gliederung): void
    {
        $this->gliederung = $gliederung;
    }

    /**
     * @return Text
     */
    public function getTourismus(): Text
    {
        return $this->tourismus;
    }

    /**
     * @param Text $tourismus
     */
    public function setTourismus(Text $tourismus): void
    {
        $this->tourismus = $tourismus;
    }

    /**
     * @return Text
     */
    public function getKlima(): Text
    {
        return $this->klima;
    }

    /**
     * @param Text $klima
     */
    public function setKlima(Text $klima): void
    {
        $this->klima = $klima;
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

    /**
     * @return Image
     */
    public function getCategoryBild(): Image
    {
        return $this->categoryBild;
    }

    /**
     * @param Image $categoryBild
     */
    public function setCategoryBild(Image $categoryBild)
    {
        $this->categoryBild = $categoryBild;
    }
}