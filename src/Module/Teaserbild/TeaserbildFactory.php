<?php declare(strict_types=1);

namespace Project\Module\Teaserbild;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;

/**
 * Class TeaserbildFactory
 * @package Project\Module\Teaserbild
 */
class TeaserbildFactory
{
    /**
     * @param $object
     *
     * @return Teaserbild
     */
    public function getTeaserbildFromObject($object): Teaserbild
    {
        /** @var Id $teaserbildId */
        $teaserbildId = Id::fromString($object->teaserbildId);

        /** @var Image $teaserbild */
        $teaserbild = Image::fromFile($object->teaserbild);

        return new Teaserbild($teaserbildId, $teaserbild);
    }
}