<?php declare(strict_types=1);

namespace Project\Module\Reise;

use Project\Module\GenericValueObject\Name;

/**
 * Class Reiseveranstalter
 * @package Project\Module\Reise
 */
class Reiseveranstalter
{
    /** @var  Name $reiseveranstalter */
    protected $reiseveranstalter;

    /** @var array $reiseList */
    protected $reiseList = [];

    public function __construct(Name $reiseveranstalter)
    {
        $this->reiseveranstalter = $reiseveranstalter;
    }

    /**
     * @return Name
     */
    public function getReiseveranstalter(): Name
    {
        return $this->reiseveranstalter;
    }

    /**
     * @return array
     */
    public function getReiseList(): array
    {
        return $this->reiseList;
    }

    /**
     * @param array $reiseList
     */
    public function setReiseList(array $reiseList)
    {
        $this->reiseList = $reiseList;
    }
}