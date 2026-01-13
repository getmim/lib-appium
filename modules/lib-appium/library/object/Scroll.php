<?php
/**
 * Scroll
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Scroll
{
    protected Session $session;

    protected object $size;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->size = $session->screenSize();
    }

    public function down(): void
    {
        $h_10 = $this->size->height * 20 / 100;
        $w_10 = $this->size->width * 20 / 100;

        $this->session->execute('mobile: scrollGesture', [
            'left' => $w_10,
            'top' => $h_10,
            'width' => $this->size->width - $w_10 * 2,
            'height' => $this->size->height - $h_10 * 2,
            'direction' => 'down',
            'percent' => 1.0
        ]);
    }

    public function to(string $using, $value): void
    {
        $this->session->exec('POST', '/execute/sync', [
            'script' => 'mobile: scroll',
            'args' => [
                'strategy' => $using,
                'selector' => $value
            ]
        ]);
    }

    public function up(): void
    {
        $h_10 = $this->size->height * 20 / 100;
        $w_10 = $this->size->width * 20 / 100;

        $this->session->execute('mobile: scrollGesture', [
            'left' => $w_10,
            'top' => $h_10,
            'width' => $this->size->width - $w_10 * 2,
            'height' => $this->size->height - $h_10 * 2,
            'direction' => 'up',
            'percent' => 1.0
        ]);
    }
}
