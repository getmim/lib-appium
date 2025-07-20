<?php
/**
 * Appium
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library;

use LibCurl\Library\Curl;
use LibAppium\Library\Object\Session;

class Appium
{
    protected static $session;

    public static function exec(string $method, string $path, array $body = [])
    {
        $config = &\Mim::$app->config->libAppium;
        $url = 'http://' . $config->host . ':' . $config->port . $path;

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
                self::$session->refresh();
            }
        }

        return $value;
    }

    public static function createSession(string $udid = null): Session
    {
        self::$session = new Session($udid);
        return self::$session;
    }
}
