<?php
/**
 * Element
 * @package lib-appium
 * @version 0.0.1
 */

namespace LibAppium\Library\Object;

class Element
{
    protected Session $session;

    protected string $id;

    public function __construct(Object $el, Session $session)
    {
        $this->id = $el->ELEMENT;
        $this->session = $session;
    }

    public function __get(string $name)
    {
        if ($name == 'id') {
            return $this->id;
        }

        $internals = [
            'displayed',
            'enabled',
            'location',
            'location_in_view',
            'name',
            // 'pageIndex',
            'rect',
            'selected',
            'size',
            'text'
        ];
        $uri = '/element/' . $this->id . '/';
        if (!in_array($name, $internals)) {
            $uri .= 'attribute/';
        }
        $uri .=  $name;

        return $this->session->exec('GET', $uri);
    }

    public function __set(string $name, $value): void
    {
        if ($name == 'value') {
            $uri = '/appium/element/' . $this->id . '/replace_value';
            $this->session->exec('POST', $uri, [
                'text' => str_split($value)
            ]);
        }
    }

    public function child(string $using, string $value): ?Element
    {
        $uri = '/element/' . $this->id . '/element';
        $el = $this->session->exec('POST', $uri, [
            'using' => $using,
            'value' => $value
        ]);

        if (isset($el->error)) {
            return null;
        }

        return new Element($el, $this->session);
    }

    public function children(string $using, string $value): array
    {
        $uri = '/element/' . $this->id . '/elements';
        $els = $this->session->exec('POST', $uri, [
            'using' => $using,
            'value' => $value
        ]);

        if (!$els) {
            return [];
        }

        $res = [];
        foreach ($els as $el) {
            $res[] = new Element($el, $this->session);
        }

        return $res;
    }

    public function clear(): void
    {
        $uri = '/element/' . $this->id . '/clear';
        $this->session->exec('POST', $uri);
    }

    public function click(): void
    {
        $uri = '/element/' . $this->id . '/click';
        $this->session->exec('POST', $uri);
    }

    public function editor(string $action): void
    {
        $this->session->execute('mobile: performEditorAction', [
            'action' => $action
        ]);
    }

    public function go(): void
    {
        $this->editor('go');
    }

    public function next(): void
    {
        $this->editor('next');
    }

    public function search(): void
    {
        $this->editor('search');
    }

    public function send(): void
    {
        $this->editor('send');
    }

    public function type(string $text): void
    {
        $uri = '/element/' . $this->id . '/value';
        $this->session->exec('POST', $uri, [
            'value' => str_split($text)
        ]);
    }

    public static function findOne(
        Session $session,
        string $using,
        string $value,
        int $retry = 0
    ): ?Element {
        $el = $session->exec('POST', '/element', [
            'using' => $using,
            'value' => $value
        ]);

        if (isset($el->error)) {
            if ($retry >= 10) {
                return null;
            }

            sleep(1);
            return self::findOne($session, $using, $value, ++$retry);
        }

        return new Element($el, $session);
    }

    public static function findAll(
        Session $session,
        string $using,
        string $value,
        int $retry = 0
    ): array {
        $els = $session->exec('POST', '/elements', [
            'using' => $using,
            'value' => $value
        ]);

        if (!$els) {
            if ($retry >= 10) {
                return [];
            }

            sleep(1);
            return self::findAll($session, $using, $value, ++$retry);
        }

        $res = [];
        foreach ($els as $el) {
            $res[] = new Element($el, $session);
        }

        return $res;
    }
}
