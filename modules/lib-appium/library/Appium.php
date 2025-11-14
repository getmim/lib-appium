<?php
/**
 * Appium
 * @package lib-appium
 * @version 1.12.0
 */

namespace LibAppium\Library;

use LibCurl\Library\Curl;
use LibAppium\Library\Object\Session;

class Appium
{
    protected static $session;

    public static function exec(
        string $method,
        string $path,
        array $body = [],
        string $server = 'http://127.0.0.1:4723'
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

        if (!$res || !isset($res->value)) {
            return;
        }

        $value = $res->value;
        if (isset($value->error)) {
            if ($value->error == 'unknown error') {
                if (self::$session) {
                    self::$session->refresh();
                } else {
                    throw new \Exception($value->message);
                }
            }
        }

        return $value;
    }

    public static function createSession(string $udid = null, string $port = null): Session
    {
        self::$session = new Session($udid, $port);
        return self::$session;
    }
}
