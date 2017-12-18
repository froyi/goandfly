<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Text;

/**
 * Class Region
 * @package Project\Module\Region
 */
class Region
{
    /** @var Id $regionId */
    protected $regionId;

    /** @var Id $continentId */
    protected $continentId;

    /** @var Name $name */
    protected $name;

    /** @var Text $beispiellaender */
    protected $beispiellaender;

    /** @var Text $beschreibung */
    protected $beschreibung;

    /** @var Image $bild */
    protected $bild;

    /**
     * Region constructor.
     * @param Id $regionId
     * @param Id $continentId
     * @param Name $name
     * @param Text $beispiellaender
     * @param Text $beschreibung
     * @param Image $bild
     */
    public function __construct(Id $regionId, Id $continentId, Name $name, Text $beispiellaender, Text $beschreibung, Image $bild)
    {
        $this->regionId = $regionId;
        $this->continentId = $continentId;
        $this->name = $name;
        $this->beispiellaender = $beispiellaender;
        $this->beschreibung = $beschreibung;
        $this->bild = $bild;
    }

    /**
     * @return Id
     */
    public function getRegionId(): Id
    {
        return $this->regionId;
    }

    /**
     * @return Id
     */
    public function getContinentId(): Id
    {
        return $this->continentId;
    }

    /**
     * @param Id $continentId
     */
    public function setContinentId(Id $continentId): void
    {
        $this->continentId = $continentId;
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
     * @return Text
     */
    public function getBeispiellaender(): Text
    {
        return $this->beispiellaender;
    }

    /**
     * @param Text $beispiellaender
     */
    public function setBeispiellaender(Text $beispiellaender): void
    {
        $this->beispiellaender = $beispiellaender;
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
}