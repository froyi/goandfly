<?php
declare (strict_types=1);

namespace Project\Module\News;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;

/**
 * Class News
 * @package Project\Module\News
 */
class News
{
    /** @var Id $newsId */
    protected $newsId;

    /** @var Title $titel */
    protected $titel;

    /** @var Date $datum */
    protected $datum;

    /** @var Text $text */
    protected $text;

    /**
     * News constructor.
     * @param Id $newsId
     * @param Title $titel
     * @param Date $date
     * @param Text $text
     */
    public function __construct(Id $newsId, Title $titel, Date $date, Text $text)
    {
        $this->newsId = $newsId;
        $this->titel = $titel;
        $this->date = $date;
        $this->text = $text;
    }

    /**
     * @return Id
     */
    public function getNewsId(): Id
    {
        return $this->newsId;
    }

    /**
     * @return Title
     */
    public function getTitel(): Title
    {
        return $this->titel;
    }

    /**
     * @param Title $titel
     */
    public function setTitel(Title $titel): void
    {
        $this->titel = $titel;
    }

    /**
     * @return Date
     */
    public function getDatum(): Date
    {
        return $this->datum;
    }

    /**
     * @param Date $datum
     */
    public function setDatum(Date $datum): void
    {
        $this->datum = $datum;
    }

    /**
     * @return Text
     */
    public function getText(): Text
    {
        return $this->text;
    }

    /**
     * @param Text $text
     */
    public function setText(Text $text): void
    {
        $this->text = $text;
    }
}