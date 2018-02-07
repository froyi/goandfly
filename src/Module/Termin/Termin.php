<?php declare(strict_types=1);

namespace Project\Module\Termin;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;

/**
 * Class Termin
 * @package Project\Module\Termine
 */
class Termin
{
    /** @var  Id $terminId */
    protected $terminId;

    /** @var  Id $reiseId */
    protected $reiseId;

    /** @var  Date $start */
    protected $start;

    /** @var  Date $ende */
    protected $ende;

    /** @var  Text $preis */
    protected $preis;

    /**
     * Termin constructor.
     *
     * @param Id $terminId
     * @param Id $reiseId
     * @param Date $start
     * @param Date $ende
     * @param Text $preis
     */
    public function __construct(Id $terminId, Id $reiseId, Date $start, Date $ende, Text $preis)
    {
        $this->terminId = $terminId;
        $this->reiseId = $reiseId;
        $this->start = $start;
        $this->ende = $ende;
        $this->preis = $preis;
    }

    /**
     * @return Id
     */
    public function getTerminId(): Id
    {
        return $this->terminId;
    }

    /**
     * @param Id $terminId
     */
    public function setTerminId(Id $terminId)
    {
        $this->terminId = $terminId;
    }

    /**
     * @return Date
     */
    public function getStart(): Date
    {
        return $this->start;
    }

    /**
     * @param Date $start
     */
    public function setStart(Date $start)
    {
        $this->start = $start;
    }

    /**
     * @return Date
     */
    public function getEnde(): Date
    {
        return $this->ende;
    }

    /**
     * @param Date $ende
     */
    public function setEnde(Date $ende)
    {
        $this->ende = $ende;
    }

    /**
     * @return Text
     */
    public function getPreis(): Text
    {
        return $this->preis;
    }

    /**
     * @param Text $preis
     */
    public function setPreis(Text $preis)
    {
        $this->preis = $preis;
    }

    /**
     * @return Id
     */
    public function getReiseId(): Id
    {
        return $this->reiseId;
    }
}