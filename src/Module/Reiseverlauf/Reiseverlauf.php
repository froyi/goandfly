<?php declare(strict_types=1);

namespace Project\Module\Reiseverlauf;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Reisetag;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;

/**
 * Class Reiseverlauf
 * @package Project\Module\Reiseverlauf
 */
class Reiseverlauf
{
    /** @var  Id $reiseverlaufId */
    protected $reiseverlaufId;

    /** @var  Id $reiseId */
    protected $reiseId;

    /** @var  Reisetag $reisetag */
    protected $reisetag;

    /** @var  Title $titel */
    protected $titel;

    /** @var  Text $beschreibung */
    protected $beschreibung;

    /**
     * Reiseverlauf constructor.
     *
     * @param Id $reiseverlaufId
     * @param Id $reiseId
     * @param Reisetag $reisetag
     * @param Title $titel
     * @param Text $beschreibung
     */
    public function __construct(Id $reiseverlaufId, Id $reiseId, Reisetag $reisetag, Title $titel, Text $beschreibung)
    {
        $this->reiseverlaufId = $reiseverlaufId;
        $this->reiseId = $reiseId;
        $this->reisetag = $reisetag;
        $this->titel = $titel;
        $this->beschreibung = $beschreibung;
    }

    /**
     * @return Id
     */
    public function getReiseverlaufId(): Id
    {
        return $this->reiseverlaufId;
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
     * @return Title
     */
    public function getTitel(): Title
    {
        return $this->titel;
    }

    /**
     * @param Title $titel
     */
    public function setTitel(Title $titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return Text
     */
    public function getBeschreibung(): Text
    {
        return $this->beschreibung;
    }

    /**
     * @param Text $beschreibung
     */
    public function setBeschreibung(Text $beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @return Reisetag
     */
    public function getReisetag(): Reisetag
    {
        return $this->reisetag;
    }

    /**
     * @param Reisetag $reisetag
     */
    public function setReisetag(Reisetag $reisetag)
    {
        $this->reisetag = $reisetag;
    }


}