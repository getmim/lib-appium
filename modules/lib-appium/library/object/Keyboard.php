<?php
/**
 * Keyboard
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Keyboard
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function hide(): void
    {
        $this->session->exec('POST', '/appium/device/hide_keyboard', [
            'strategy' => 'default'
        ]);
    }

    public function isShown(): bool
    {
        return $this->session->exec('GET', '/appium/device/is_keyboard_shown');
    }

    public function longPress(int $key): void
    {
        $this->session->exec('POST', '/appium/device/long_press_keycode', [
            'keycode' => $key
        ]);
    }

    public function press(int $key): void
    {
        $this->session->exec('POST', '/appium/device/press_keycode', [
            'keycode' => $key
        ]);
    }
}
