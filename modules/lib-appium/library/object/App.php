<?php
/**
 * App
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class App
{
    protected string $id;
    protected Session $session;

    public function __construct(string $id, Session $session)
    {
        $this->id = $id;
        $this->session = $session;
    }

    public function background(int $seconds)
    {
        $this->session->exec('POST', '/appium/app/background', [
            'seconds' => $seconds
        ]);
    }

    public function getPermissions(string $type = null): array
    {
        $types = [
            'denied',
            'granted',
            'requested'
        ];

        $proc_types = $types;

        if ($type) {
            $proc_types = [$type];
        }

        $result = [];
        foreach ($proc_types as $type) {
            $res = $this->session->execute('mobile: getPermissions', [
                'type' => $type,
                'appPackage' => $this->id
            ]);

            foreach ($res as $perm) {
                $result[$perm] = $type;
            }
        }

        return $result;
    }

    public function close(): void
    {
        $this->session->execute('mobile: terminateApp', [
            'appId' => $this->id
        ]);
    }

    public function isInstalled(): bool
    {
        return $this->session->exec('POST', '/appium/device/app_installed', [
            'bundleId' => $this->id
        ]);
    }

    public function open(): void
    {
        $this->session->execute('mobile: activateApp', [
            'appId' => $this->id
        ]);
    }

    public function remove(): void
    {
        $this->session->exec('POST', '/appium/device/remove_app', [
            'bundleId' => $this->id
        ]);
    }

    public function setPermission(string $name, string $type): void
    {
        $this->session->execute('mobile: changePermissions', [
            'permissions' => $name,
            'appPackage' => $this->id,
            'action' => $type,
            'target' => 'pm'
        ]);
    }

    public function state(): int
    {
        return $this->session->execute('mobile: queryAppState', [
            'appId' => $this->id
        ]);
    }
}
