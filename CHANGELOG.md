# Changelog

## [v0.1.1] - 2025-06-04

### ✨ Features 
 - **Allow to specify `ecs.php` config file path**
   - You can now pass `ecs_path` config param to `new CodeFixer(['ecs_path' => 'path'])`
   - Override on the fly via  `$fixer->{fix|check|execute}(['ecs_path' => 'path'])`

## [v0.1.0] - 2025-03-19

🚀 **Initial Release!**

We’re excited to announce the first release of **justcoded/php-cs-fixer**! 🎉

### ✨ Features

- **Preconfigured ECS setup**:
    - Includes recommended rules from:
        - `symplify/coding-standard`
        - `slevomat/coding-standard`
        - `php-cs-fixer`
        - `php-cs-fixer-custom-fixers`
        - `squizlabs/php_codesniffer`
- **Programmatic API**:
    - `CodeFixer` service to run checks and fixes via PHP code.
    - Supports custom paths and configuration options (e.g., `tty`).
- **Laravel Integration**:
    - Provides a Service Provider with out-of-the-box configuration file publishing.
    - Registers `CodeFixer` as a scoped singleton within Laravel's service container.
    - Default config (`config/php-cs-fixer.php`) includes `tty` setup.

### 🔧 Usage Highlights

#### CLI

```bash
./vendor/bin/ecs check
./vendor/bin/ecs check --fix
```

#### Programmatically

```php
use JustCoded\PhpCsFixer\Services\CodeFixer;

$fixer = new CodeFixer();
$result = $fixer->check(path: 'app/');
```

#### Laravel

```php
app(\JustCoded\PhpCsFixer\Services\CodeFixer::class)->fix(config: ['tty' => true]);
```

### ⚙️ Custom Configuration File Support

You can override the default ECS config by placing your own `ecs.php` file in the project root:

```php
<?php

use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import('vendor/justcoded/php-cs-fixer/config/ecs.php');

    // Add your custom rules here
};
```

The package will automatically detect and use your custom config file.

---

Thank you for using **justcoded/php-cs-fixer**! 🙌

