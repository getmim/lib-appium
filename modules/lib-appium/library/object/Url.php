<?php
/**
 * App
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Url
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function open(string $url): void
    {
        $this->session->exec('POST', '/url', [
            'url' => $url
        ]);
    }
}
