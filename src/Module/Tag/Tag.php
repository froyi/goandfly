<?php declare(strict_types=1);

namespace Project\Module\Tag;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Name;
use Project\Module\GenericValueObject\Position;

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

    /** @var Position $position */
    protected $position;

    /**
     * Tag constructor.
     *
     * @param Id $tagId
     * @param Name $name
     * @param Position $position
     */
    public function __construct(Id $tagId, Name $name, Position $position)
    {
        $this->tagId = $tagId;
        $this->name = $name;
        $this->position = $position;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
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