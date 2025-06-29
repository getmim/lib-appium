<?php
/**
 * Interaction
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Interaction
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function isLocked(): bool
    {
        return $this->session->exec('POST', '/appium/device/is_locked');
    }

    public function lock(): void
    {
        $this->session->exec('POST', '/appium/device/lock');
    }

    public function unlock(): void
    {
        $this->session->exec('POST', '/appium/device/unlock');
    }
}
