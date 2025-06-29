<?php
/**
 * Context
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Clipboard
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function get(): string
    {
        $res = $this->session->exec('POST', '/appium/device/get_clipboard', [
            'contentType' => 'plaintext'
        ]);

        return base64_decode($res);
    }

    public function set(string $value): void
    {
        $this->session->exec('POST', '/appium/device/set_clipboard', [
            'content' => base64_encode($value),
            'contentType' => 'plaintext',
            'label' => $value
        ]);
    }
}
