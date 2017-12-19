<?php declare(strict_types=1);

namespace Project\Module\Teaserbild;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Image;

/**
 * Class Teaserbild
 * @package Project\Module\Teaserbild
 */
class Teaserbild
{
    /** @var  Id $teaserbildId */
    protected $teaserbildId;

    /** @var  Image $teaserbild */
    protected $teaserbild;

    /**
     * Teaserbild constructor.
     *
     * @param Id $teaserbildId
     * @param Image $teaserbild
     */
    public function __construct(Id $teaserbildId, Image $teaserbild)
    {
        $this->teaserbildId = $teaserbildId;
        $this->teaserbild = $teaserbild;
    }

    /**
     * @return Id
     */
    public function getTeaserbildId(): Id
    {
        return $this->teaserbildId;
    }

    /**
     * @return Image
     */
    public function getTeaserbild(): Image
    {
        return $this->teaserbild;
    }

    /**
     * @param Image $teaserbild
     */
    public function setTeaserbild(Image $teaserbild)
    {
        $this->teaserbild = $teaserbild;
    }
}