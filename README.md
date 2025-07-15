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
11. `screenshot(): string`
12. `scroll(string $target, int $distance): void`
13. `search(): void`
14. `send(): void`
15. `type(string $text): void`
16. `static findOne(Session $session, string $using, string $value, $wait = false, int $retry = 10): ?Element`
17. `static findAll( Session $session, string $using, string $value, $wait = false, int $retry = 10): array`

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
13. `gesture(string $gesture, array $options): void`
14. `home(): void`
15. `interaction(): Interaction`
16. `keyboard(): Keyboard`
17. `notification(): Notification`
18. `exec(string $method, string $path, array $body = [])`
19. `execute(string $script, array $args = [])`
20. `screenshot(): object`
21. `screenSize(): object`
22. `scroll(): void`
23. `shell(array $args): ?string`
24. `sms(): Sms`
25. `source(): ?string`
26. `time(): string`
27. `url(): Url`

### LibAppium\Library\Object\Sms

1. `__construct(Session $session)`
2. `getAll(): array`
3. `getLast(): ?object`

### LibAppium\Library\Object\Url

1. `__construct(Session $session)`
2. `open(string $url): void`
