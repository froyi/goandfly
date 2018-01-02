<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;

/**
 * Class NewsFactory
 * @package Project\Module\News
 */
class NewsFactory
{
    /**
     * @param $object
     * @return News
     */
    public function getNewsFromObject($object): News
    {
        /** @var Id $newsId */
        $newsId = Id::fromString($object->newsId);
        /** @var Title $titel */
        $titel = Title::fromString($object->titel);
        /** @var Date $datum */
        $datum = Date::fromValue($object->datum);
        /** @var Text $text */
        $text = Text::fromString($object->text);

        return new News($newsId, $titel, $datum, $text);
    }

    /**
     * @param $object
     * @return bool
     */
    public function isObjectValid($object): bool
    {
        try {
            /** @var Id $newsId */
            $newsId = Id::fromString($object->newsId);
            /** @var Title $titel */
            $titel = Title::fromString($object->titel);
            /** @var Date $datum */
            $datum = Date::fromValue($object->datum);
            /** @var Text $text */
            $text = Text::fromString($object->text);

            new News($newsId, $titel, $datum, $text);
        } catch (\InvalidArgumentException $error) {
            return false;
        }

        return true;
    }
}