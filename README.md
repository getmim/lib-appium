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
5. `waitFor(): bool`

### LibAppium\Library\Object\App

1. `__construct(string $id, Session $session)`
2. `backTo(string $activity): void`
3. `background(int $seconds)`
4. `getId(): string`
5. `getPermissions(string $type = null): array`
6. `close(): void`
7. `isInstalled(): bool`
8. `open(): void`
9. `remove(): void`
10. `setPermission(string $name, string $type): void`
11. `start(string $activity): void`
12. `state(): int`

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
14. `static findOne(Session $session, string $using, string $value, $wait = false, int $retry = 10): ?Element`
15. `static findAll( Session $session, string $using, string $value, $wait = false, int $retry = 10): array`

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

### LibAppium\Library\Object\Scroll

1. `__construct(Session $session)`
2. `down(): void`
3. `to(string $using, $value): void`
4. `up(): void`

### LibAppium\Library\Object\Session

1. `__construct()`
2. `app(string $id): App`
3. `back(): void`
4. `activity(): Activity`
5. `battery(): object`
6. `context(): Context`
7. `clearRecent(): void`
8. `clipboard(): Clipboard`
9. `device(): ?object`
10. `element(string $using, string $value, bool $wait = false): ?Element`
11. `elements(string $using, string $value, bool $wait = false): array`
12. `refresh(): void`
13. `home(): void`
14. `interaction(): Interaction`
15. `keyboard(): Keyboard`
16. `notification(): Notification`
17. `exec(string $method, string $path, array $body = [])`
18. `execute(string $script, array $args = [])`
19. `screenshot(): object`
20. `screenSize(): object`
21. `scroll(): void`
22. `shell(array $args): ?string`
23. `sms(): Sms`
24. `source(): ?string`
25. `time(): string`
26. `url(): Url`

### LibAppium\Library\Object\Sms

1. `__construct(Session $session)`
2. `getAll(): array`
3. `getLast(): ?object`

### LibAppium\Library\Object\Url

1. `__construct(Session $session)`
2. `open(string $url): void`
