<?php
declare(strict_types=1);

namespace Project\Utilities;

use Project\Configuration;

/**
 * Class Notification
 *
 * notificationCode
 * Module|Function|Status
 *
 * @package Project\Utilities
 */
class Notification
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    /** @var  string $notificationCode */
    protected $notificationCode;

    /** @var  string $notificationMessage */
    protected $notificationMessage;

    /** @var  string $notificationStatus */
    protected $notificationStatus;

    /** @var  array $notificationConfig */
    protected $notificationConfig;

    public function __construct(Configuration $configuration)
    {
        $this->notificationConfig = $configuration->getEntryByName('notification');
    }

    /**
     * @return string
     */
    public function getNotificationCode(): ?string
    {
        return $this->notificationCode;
    }

    /**
     * @param string $notificationCode
     */
    public function setNotificationCode(string $notificationCode)
    {
        if (isset($this->notificationConfig[$notificationCode])) {
            $this->notificationCode = $notificationCode;
            $this->notificationMessage = $this->notificationConfig[$notificationCode];
        }
    }

    /**
     * @return string
     */
    public function getNotificationMessage(): ?string
    {
        return $this->notificationMessage;
    }

    /**
     * @return string
     */
    public function getNotificationStatus(): ?string
    {
        return $this->notificationStatus;
    }

    /**
     * @param string $notificationStatus
     */
    public function setNotificationStatus(string $notificationStatus)
    {
        $this->notificationStatus = $notificationStatus;
    }
}