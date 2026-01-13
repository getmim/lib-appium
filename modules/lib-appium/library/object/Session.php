<?php
/**
 * Session
 * @package lib-appium
 * @version 1.11.0
 */

namespace LibAppium\Library\Object;

use LibAppium\Library\Appium;
use Cli\Library\Bash;

class Session
{
    protected ?object $session;
    protected int $retry = 0;
    protected array $options;

    protected function createSession(bool $force = false): void
    {
        $this->session = null;
        if ($this->retry > 5) {
            throw new \Exception('Unable to retrieve appium session');
        }

        $server = $this->options['appium_address'];

        // Try get from exists session
        $res = Appium::exec('GET', '/appium/sessions', [], $server);
        if ($res) {
            if (!$force) {
                $this->session = (object)[
                    'sessionId' => $res[0]->id
                ];
                return;
            } else {
                foreach ($res as $re) {
                    Appium::exec('DELETE', '/session/' . $re->id, [], $server);
                }
            }
        }

        $body = [
            'capabilities' => [
                'alwaysMatch' => [
                    'platformName' => 'Android',
                    'appium:automationName' => 'UiAutomator2',
                    'appium:deviceName' => 'Android',
                    'appium:newCommandTimeout' => 0,
                    'appium:disableWindowAnimation' => true,
                    // 'appium:skipDeviceInitialization' => true,
                    // 'appium:skipServerInstallation' => true,
                    'appium:ignoreHiddenApiPolicyError' => true,
                    // 'appium:hideKeyboard' => true,
                    'appium:allowDelayAdb' => false,
                    'appium:udid' => $this->options['android_id'],
                    'appium:systemPort' => $this->options['system_port'],
                    'appium:adbPort' => $this->options['adb_port'],
                    'appium:dontStopAppOnReset' => true
                ]
            ]
        ];

        $info = 'lib-appium[Session]: Create new session on ' . $server;
        if ($this->retry > 0) {
            $info .= ' (Retry ' . $this->retry . ')';
        }
        Bash::echo($info);
        $res = Appium::exec('POST', '/session', $body, $server);

        if (!$res || isset($res->error)) {
            // if (!is_null($res)) {
            //     deb($res);
            // }
            $this->retry++;
            sleep(1);
            $this->createSession(true);
            return;
        }

        $this->session = $res;
    }

    public function __construct(array $options)
    {
        $this->options = $options;
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
        return $this->exec('POST', '/execute/sync', [
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

        $sels = [
            ['id', 'com.android.launcher:id/btn_clear'],
            ['id', 'com.android.launcher3:id/action_clean']
        ];

        foreach ($sels as $sel) {
            $el = $this->element($sel[0], $sel[1]);
            if ($el) {
                $el->click();
                break;
            }
        }
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
        return $this->exec('POST', '/execute/sync', [
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

    public function gesture(string $gesture, array $options): void
    {
        $name = 'mobile: ' . $gesture . 'Gesture';
        $this->execute($name, $options);
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
        $spath = '/session/' . $this->session->sessionId . $path;
        $server = $this->options['appium_address'];
        $result = Appium::exec($method, $spath, $body, $server);

        $reset = [
            'unknown error',
            'invalid session id'
        ];
        if (isset($result->error) && in_array($result->error, $reset)) {
            $this->createSession(true);
            return $this->exec($method, $path, $body);
        }

        return $result;
    }

    public function execute(string $script, array $args = [])
    {
        return $this->exec('POST', '/execute/sync', [
            'script' => $script,
            'args' => $args
        ]);
    }

    public function refresh(): void
    {
        $this->createSession(true);
    }

    public function screenshot(): string
    {
        return $this->exec('GET', '/screenshot');
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
        $result = $this->exec('GET', '/source');
        return is_string($result) ? $result : null;
    }

    public function time(): string
    {
        return $this->exec('POST', '/execute/sync', [
            'script' => 'mobile: getDeviceTime',
            'args' => []
        ]);
    }

    public function url(): Url
    {
        return new Url($this);
    }
}
