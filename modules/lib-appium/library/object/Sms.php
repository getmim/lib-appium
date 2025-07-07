<?php
/**
 * Sms
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Sms
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getAll(): array
    {
        $res = $this->session->execute('mobile: listSms', []);
        return $res->statusBarNotifications ?? [];
    }

    public function getLast(): ?object
    {
        $res = $this->getAll();
        if (!$res) {
            return null;
        }

        return $res[0];
    }
}
