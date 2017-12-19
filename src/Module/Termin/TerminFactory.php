<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class TerminFactory
 * @package Project\Module\Termin
 */
class TerminFactory
{
    /**
     * @param $object
     *
     * @return Termin
     */
    public function getTerminFromObject($object): Termin
    {
        /** @var Id $terminId */
        $terminId = Id::fromString($object->terminId);

        /** @var Id $reiseId */
        $reiseId = Id::fromString($object->reiseId);

        /** @var Date $start */
        $start = Date::fromValue($object->start);

        /** @var Date $ende */
        $ende = Date::fromValue($object->ende);

        /** @var Text $preis */
        $preis = Text::fromString($object->preis);

        return new Termin($terminId, $reiseId, $start, $ende, $preis);
    }
}