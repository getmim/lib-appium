<?php
/**
 * Session
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

use LibAppium\Library\Appium;

class Session
{
    protected object $session;

    protected function createSession(): void
    {
        $body = [
            'capabilities' => [
                'alwaysMatch' => [
                    'platformName' => 'Android',
                    'appium:automationName' => 'UiAutomator2',
                    'appium:deviceName' => 'Android'
                ]
            ]
        ];

        $res = Appium::exec('POST', '/session', $body);

        $this->session = $res;
    }

    public function __construct()
    {
        $this->createSession();
    }

    public function app(string $id): App
    {
        return new App($id, $this);
    }

    public function activity(): Activity
    {
        return new Activity($this);
    }

    public function back(): void
    {
        $this->exec('POST', '/appium/device/press_keycode', [
            'keycode' => 4
        ]);
    }

    public function battery(): object
    {
        return $this->exec('POST', '/execute', [
            'script' => 'mobile: batteryInfo',
            'args' => []
        ]);
    }

    public function clearRecent(): void
    {
        $this->home();
        $this->exec('POST', '/appium/device/press_keycode', [
            'keycode' => 187
        ]);

        $el = $this->element('id', 'com.android.launcher:id/btn_clear');
        $el->click();
    }

    public function context(): Context
    {
        return new Context($this);
    }

    public function clipboard(): Clipboard
    {
        return new Clipboard($this);
    }

    public function device(): ?object
    {
        return $this->exec('POST', '/execute', [
            'script' => 'mobile: deviceInfo',
            'args' => []
        ]);
    }

    public function element(
        string $using,
        string $value,
        bool $wait = false
    ): ?Element {
        return Element::findOne($this, $using, $value, $wait);
    }

    public function elements(
        string $using,
        string $value,
        bool $wait = false
    ): array {
        return Element::findAll($this, $using, $value, $wait);
    }

    public function home(): void
    {
        $this->exec('POST', '/appium/device/press_keycode', [
            'keycode' => 3
        ]);
    }

    public function interaction(): Interaction
    {
        return new Interaction($this);
    }

    public function keyboard(): Keyboard
    {
        return new Keyboard($this);
    }

    public function notification(): Notification
    {
        return new Notification($this);
    }

    public function exec(string $method, string $path, array $body = [])
    {
        $path = '/session/' . $this->session->sessionId . $path;
        return Appium::exec($method, $path, $body);
    }

    public function execute(string $script, array $args = [])
    {
        return $this->exec('POST', '/execute', [
            'script' => $script,
            'args' => $args
        ]);
    }

    public function screenshot(): object
    {
        return $this->execute('mobile: screenshots');
    }

    public function screenSize(): object
    {
        $result = $this->shell([
            'command' => 'wm',
            'args' => ['size']
        ]);

        preg_match('!([0-9]+)x([0-9]+)!', $result, $match);

        return (object)[
            'width' => (int)$match[1],
            'height' => (int)$match[2]
        ];
    }

    public function scroll(): Scroll
    {
        return new Scroll($this);
    }

    public function shell(array $args): ?string
    {
        return $this->execute('mobile: shell', $args);
    }

    public function sms(): Sms
    {
        return new Sms($this);
    }

    public function source(): ?string
    {
        return $this->exec('GET', '/source');
    }

    public function time(): string
    {
        return $this->exec('POST', '/execute', [
            'script' => 'mobile: getDeviceTime',
            'args' => []
        ]);
    }

    public function url(): Url
    {
        return new Url($this);
    }
}
