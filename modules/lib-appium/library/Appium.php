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

        return $res->value;
    }

    public static function createSession(): Session
    {
        return new Session();
    }
}
