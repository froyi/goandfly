<?php
declare (strict_types=1);

namespace Project\Module\Tag;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Reise\ReiseService;

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

    /**
     * @param Id $reiseId
     *
     * @return array
     */
    public function getTagsByReiseId(Id $reiseId): array
    {
        $tagsArray = [];

        $tags = $this->tagRepository->getTagsByReiseId($reiseId);

        foreach ($tags as $tagData) {
            $tag = $this->tagFactory->getTagFromObject($tagData);
            $tagsArray[$tag->getTagId()->toString()] = $tag;
        }

        return $tagsArray;
    }

    /**
     * @param array $tagArray
     *
     * @return array
     */
    public function getTagsByTagIdArray(array $tagArray): array
    {
        $tagsArray = [];

        foreach ($tagArray as $tagId) {
            $tagId = Id::fromString($tagId);

            $tagData = $this->tagRepository->getTagByTagId($tagId);
            $tag = $this->tagFactory->getTagFromObject($tagData);

            $tagsArray[$tag->getTagId()->toString()] = $tag;
        }

        return $tagsArray;
    }

    /**
     * @param array $tags
     */
    public function saveTagsToSession(array $tags = []): void
    {
        $this->unsetTagsInSession();

        foreach ($tags as $tag) {
            /** @var Id $tagId */
            $tagId = $tag->getTagId()->toString();
            $_SESSION['tagIds'][$tagId] = $tagId;
        }
    }

    public function unsetTagsInSession(): void
    {
        unset($_SESSION['tagIds']);
    }

    /**
     * @param ReiseService $reiseService
     * @return array
     */
    public function getTagsWithReisen(ReiseService $reiseService): array
    {
        $tagsArray = [];

        $tags = $this->getAllTags();

        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $reisen = $reiseService->getAllReisenByTagId($tag->getTagId());

            $tag->setReiseList($reisen);

            $tagsArray[$tag->getTagId()->toString()] = $tag;
        }

        return $tagsArray;
    }

    public function saveTagsToReiseInDatabase(array $tags, Id $reiseId): bool
    {
        $this->tagRepository->deleteAllTagsFromReise($reiseId);

        foreach ($tags as $tag) {
            if ($this->tagRepository->saveTagToReise($tag, $reiseId) === false) {
                return false;
            }
        }

        return true;
    }
}