<?php
/**
 * App
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Notification
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getAll(): array
    {
        $res = $this->session->execute('mobile: getNotifications', []);
        return $res->statusBarNotifications ?? [];
    }

    public function open(): void
    {
        $this->session->exec('POST', '/appium/device/open_notifications');
    }
}
