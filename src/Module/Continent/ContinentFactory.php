<?php
declare (strict_types=1);

namespace Project\Module\Continent;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Text;

/**
 * Class ContinentFactory
 * @package Project\Module\Continent
 */
class ContinentFactory
{
    /**
     * @param $object
     * @return Continent
     * @throws \InvalidArgumentException
     */
    public function getContinentFromObject($object): Continent
    {
        /** @var Id $id */
        $id = Id::fromString($object->continentId);
        /** @var Name $name */
        $name = Name::fromString($object->name);
        /** @var Text $flaeche */
        $flaeche = Text::fromString($object->flaeche);
        /** @var Text $gliederung */
        $gliederung = Text::fromString($object->gliederung);
        /** @var Text $tourismus */
        $tourismus = Text::fromString($object->tourismus);
        /** @var Text $klima */
        $klima = Text::fromString($object->klima);
        /** @var Image $bild */
        $bild = Image::fromFile($object->bild);

        return new Continent($id, $name, $flaeche, $gliederung, $tourismus, $klima, $bild);
    }
}