<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Reisetag;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;

/**
 * Class ReiseverlaufFactory
 * @package Project\Module\Reiseverlauf
 */
class ReiseverlaufFactory
{
    /**
     * @param $object
     *
     * @return Reiseverlauf
     */
    public function getReiseverlaufFromObject($object): Reiseverlauf
    {
        $reiseverlaufId = Id::fromString($object->reiseverlaufId);
        $reiseId = Id::fromString($object->reiseId);
        $reisetag = Reisetag::fromValue($object->reisetag);
        $titel = Title::fromString($object->titel);
        $beschreibung = Text::fromString($object->beschreibung);

        return new Reiseverlauf($reiseverlaufId, $reiseId, $reisetag, $titel, $beschreibung);
    }
}