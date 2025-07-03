# lib-appium

## Instalasi

```
mim app install lib-appium
```

## Konfigurasi

Tambahkan konfigurasi seperti dibawah pada konfigurasi aplikasi:

```
[
    'libAppium' => [
        'host' => '127.0.0.1',
        'port' => '4723'
    ]
]
```

## Appium

Jalankan appium server dengan perintah:

```
appium --use-plugins=inspector --allow-cors
```

## Penggunaan

Daftar command bisa dilihat di https://github.com/appium/appium-uiautomator2-driver

```php
<?php

use LibAppium\Library\Appium;

$appium = new Appium();

$appium->mobile->shell([
    'command' => 'ls',
    'args' => [
        '-la'
    ]
]);
```

## Classes

### LibAppium\Library\Appium

1. `exec(string $method, string $path, array $body = [])`
2. `createSession(): Session`

### LibAppium\Library\Object\Activity

1. `__construct(Session $session)`
2. `getCurrent(): ?string`
3. `getPackage(): ?string`
4. `start(array $args): void`

### LibAppium\Library\Object\App

1. `__construct(string $id, Session $session)`
2. `background(int $seconds)`
3. `getId(): string`
4. `getPermissions(string $type = null): array`
5. `close(): void`
6. `isInstalled(): bool`
7. `open(): void`
8. `remove(): void`
9. `setPermission(string $name, string $type): void`
10. `state(): int`

### LibAppium\Library\Object\Clipboard

1. `__construct(Session $session)`
2. `get(): string`
3. `set(string $value): void`

### LibAppium\Library\Object\Context

1. `__construct(Session $session)`
2. `getAll(): array`
3. `getOne(): string`

### LibAppium\Library\Object\Element

1. `__construct(Object $el, Session $session)`
2. `__get(string $name)`
3. `__set(string $name, $value): void`
4. `child(string $using, string $value): ?Element`
5. `children(string $using, string $value): array`
6. `clear(): void`
7. `click(): void`
8. `editor(string $action): void`
9. `go(): void`
10. `next(): void`
11. `search(): void`
12. `send(): void`
13. `type(string $text): void`
14. `static findOne(Session $session, string $using, string $value, int $retry = 0): ?Element`
15. `static findAll( Session $session, string $using, string $value, int $retry = 0): array`

### LibAppium\Library\Object\Interaction

1. `__construct(Session $session)`
2. `isLocked(): bool`
3. `lock(): void`
4. `unlock(): void`

### LibAppium\Library\Object\Keyboard

1. `__construct(Session $session)`
2. `hide(): void`
3. `isShown(): bool`
4. `longPress(int $key): void`
5. `press(int $key): void`

### LibAppium\Library\Object\Notification

1. `__construct(Session $session)`
2. `getAll(): array`
3. `open(): void`

### LibAppium\Library\Object\Session

1. `__construct()`
2. `app(string $id): App`
3. `back(): void`
4. `activity(): Activity`
5. `battery(): object`
6. `context(): Context`
7. `clipboard(): Clipboard`
8. `device(): ?object`
9. `element(string $using, string $value): ?Element`
10. `elements(string $using, string $value): array`
11. `home(): void`
12. `interaction(): Interaction`
13. `keyboard(): Keyboard`
14. `notification(): Notification`
15. `exec(string $method, string $path, array $body = [])`
16. `execute(string $script, array $args = [])`
17. `screenshot(): object`
18. `scrollTo(string $using, $value)`
19. `shell(array $args): ?string`
20. `sms(): Sms`
21. `source(): ?string`
22. `time(): string`
23. `url(): Url`

### LibAppium\Library\Object\Sms

1. `__construct(Session $session)`
2. `getAll(): array`

### LibAppium\Library\Object\Url

1. `__construct(Session $session)`
2. `open(string $url): void`
