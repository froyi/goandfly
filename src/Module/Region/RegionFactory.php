<?php
declare (strict_types=1);

namespace Project\Module\Region;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Text;

/**
 * Class RegionFactory
 * @package Project\Module\Region
 */
class RegionFactory
{
    /**
     * @param $object
     * @return Region
     */
    public function getRegionFromObject($object): Region
    {
        $regionId = Id::fromString($object->regionId);
        $continentId = Id::fromString($object->continentId);
        $name = Name::fromString($object->name);
        $beispiellaender = Text::fromString($object->beispiellaender);
        $beschreibung = Text::fromString($object->beschreibung);
        $bild = Image::fromFile($object->bild);

        return new Region($regionId, $continentId, $name, $beispiellaender, $beschreibung, $bild);
    }
}