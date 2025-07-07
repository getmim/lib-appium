<?php
/**
 * Activity
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Activity
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getCurrent(): ?string
    {
        return $this->session->exec('GET', '/appium/device/current_activity');
    }

    public function getPackage(): ?string
    {
        return $this->session->exec('GET', '/appium/device/current_package');
    }

    public function start(array $args): void
    {
        $this->session->exec('POST', '/appium/device/start_activity', $args);
    }

    public function waitFor(string $name): bool
    {
        for ($i=0; $i<15; $i++) {
            if ($this->getCurrent() == $name) {
                return true;
            }

            sleep(1);
        }

        return false;
    }
}
