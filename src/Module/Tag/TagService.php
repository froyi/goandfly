<?php
declare (strict_types=1);

namespace Project\Module\Tag;

use Project\Module\Database\Database;

/**
 * Class TagService
 * @package Project\Module\Tag
 */
class TagService
{
    /** @var TagFactory $tagFactory */
    protected $tagFactory;

    /** @var TagRepository $tagRepository */
    protected $tagRepository;

    /**
     * TagService constructor.
     */
    public function __construct(Database $database)
    {
        $this->tagFactory = new TagFactory();
        $this->tagRepository = new TagRepository($database);
    }

    /**
     * @return array
     */
    public function getAllTags(): array
    {
        $tagsArray = [];

        $tags = $this->tagRepository->getAllTags();

        foreach ($tags as $tagData) {
            $tag = $this->tagFactory->getTagFromObject($tagData);
            $tagsArray[$tag->getTagId()->toString()] = $tag;
        }

        return $tagsArray;
    }
}