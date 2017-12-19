<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class FrageFactory
 * @package Project\Module\Frage
 */
class FrageFactory
{
    /**
     * @param $object
     * @return Frage
     */
    public function getFrageFromObject($object): Frage
    {
        $frageId = Id::fromString($object->frageId);
        $reiseId = Id::fromString($object->reiseId);
        $frage = Text::fromString($object->frage);
        $antwort = Text::fromString($object->antwort);

        return new Frage($frageId, $reiseId, $frage, $antwort);
    }
}