<?php declare(strict_types=1);

namespace Project\Module\Tag;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Name;

/**
 * Class Tag
 * @package Project\Module\Tag
 */
class Tag
{
    /** @var  Id $tagId */
    protected $tagId;

    /** @var  Name $name */
    protected $name;

    /**
     * Tag constructor.
     *
     * @param Id $tagId
     * @param Name $name
     */
    public function __construct(Id $tagId, Name $name)
    {
        $this->tagId = $tagId;
        $this->name = $name;
    }

    /**
     * @return Id
     */
    public function getTagId(): Id
    {
        return $this->tagId;
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
    public function setName(Name $name)
    {
        $this->name = $name;
    }
}