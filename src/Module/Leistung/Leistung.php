<?php declare(strict_types=1);

namespace Project\Module\Leistung;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class Leistung
 * @package Project\Module\Leistungen
 */
class Leistung
{
    /** @var  Id $leistungId */
    protected $leistungId;

    /** @var  Id $reiseId */
    protected $reiseId;

    /** @var  Text $text */
    protected $text;

    /**
     * Leistung constructor.
     * @param Id $leistungId
     * @param Id $reiseId
     * @param Text $text
     */
    public function __construct(Id $leistungId, Id $reiseId, Text $text)
    {
        $this->leistungId = $leistungId;
        $this->reiseId = $reiseId;
        $this->text = $text;
    }

    /**
     * @return Id
     */
    public function getLeistungId(): Id
    {
        return $this->leistungId;
    }

    /**
     * @return Id
     */
    public function getReiseId(): Id
    {
        return $this->reiseId;
    }

    /**
     * @param Id $reiseId
     */
    public function setReiseId(Id $reiseId)
    {
        $this->reiseId = $reiseId;
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
    public function setText(Text $text)
    {
        $this->text = $text;
    }


}