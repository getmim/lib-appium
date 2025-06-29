<?php
/**
 * Context
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Context
{
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getAll(): array
    {
        return $this->session->exec('GET', '/contexts');
    }

    public function getOne(): string
    {
        return $this->session->exec('GET', '/context');
    }
}
