<?php
/**
 * Appium
 * @package lib-appium
 * @version 1.12.0
 */

namespace LibAppium\Library;

use LibCurl\Library\Curl;
use LibAppium\Library\Object\Session;
use Cli\Library\Bash;

class Appium
{
    protected static $session;

    public static function exec(
        string $method,
        string $path,
        array $body = [],
        ?string $server = 'http://127.0.0.1:4723'
    ) {
        $url = $server . $path;

        $res = Curl::fetch([
            'url' => $url,
            'method' => $method,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
            'body' => $body
        ]);

        if (!$res) {
            return;
        }

        $value = $res->value ?? null;
        if (isset($value->error)) {
            Bash::echo('lib-appium[Appium]: ' . $value->error);
            if ($value->error == 'unknown error') {
                if (self::$session) {
                    self::$session->refresh();
                }
            }
        }

        return $value;
    }

    public static function createSession(array $options): Session
    {
        self::$session = new Session($options);
        return self::$session;
    }
}
