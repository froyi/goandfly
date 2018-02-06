<?php
declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class LeistungFactory
 * @package Project\Module\Leistung
 */
class LeistungFactory
{
    /**
     * @param $object
     * @return Leistung
     */
    public function getLeistungFromObject($object): Leistung
    {
        $leistungId = Id::fromString($object->leistungId);
        $reiseId = Id::fromString($object->reiseId);
        $text = Text::fromString($object->text);

        return new Leistung($leistungId, $reiseId, $text);
    }

    public function isObjectValid($object): bool
    {
        try {
            $this->getLeistungFromObject($object);
        } catch (\InvalidArgumentException $error) {
            return false;
        }

        return true;
    }
}