<?php
declare (strict_types=1);

namespace Project\Module\Frage;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class Frage
 * @package Project\Module\Frage
 */
class Frage
{
    /** @var Id $frageId */
    protected $frageId;

    /** @var Id $reiseId */
    protected $reiseId;

    /** @var Text $frage */
    protected $frage;

    /** @var Text $antwort */
    protected $antwort;

    /**
     * Frage constructor.
     * @param Id $frageId
     * @param Id $reiseId
     * @param Text $frage
     * @param Text $antwort
     */
    public function __construct(Id $frageId, Id $reiseId, Text $frage, Text $antwort)
    {
        $this->frageId = $frageId;
        $this->reiseId = $reiseId;
        $this->frage = $frage;
        $this->antwort = $antwort;
    }

    /**
     * @return Id
     */
    public function getFrageId(): Id
    {
        return $this->frageId;
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
    public function setReiseId(Id $reiseId): void
    {
        $this->reiseId = $reiseId;
    }

    /**
     * @return Text
     */
    public function getFrage(): Text
    {
        return $this->frage;
    }

    /**
     * @param Text $frage
     */
    public function setFrage(Text $frage): void
    {
        $this->frage = $frage;
    }

    /**
     * @return Text
     */
    public function getAntwort(): Text
    {
        return $this->antwort;
    }

    /**
     * @param Text $antwort
     */
    public function setAntwort(Text $antwort): void
    {
        $this->antwort = $antwort;
    }
}