# JustCoded PHP-CS-Fixer

<p align="center">
    <a href="https://packagist.org/packages/justcoded/php-cs-fixer">
        <img src="https://img.shields.io/packagist/v/justcoded/php-cs-fixer.svg?style=flat-rounded" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/justcoded/php-cs-fixer">
        <img src="https://img.shields.io/packagist/dt/justcoded/php-cs-fixer.svg?style=flat-rounded" alt="Total Downloads">
    </a>
    <a href="https://github.com/MasterRO94/laravel-mail-viewer/blob/master/LICENSE">
        <img src="https://img.shields.io/github/license/MasterRO94/laravel-mail-viewer" alt="License">
    </a>
</p>

<p align="center">
    <a href="https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md">
        <img src="https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg" alt="StandWithUkraine">
    </a>
</p>

A preconfigured **[Easy Coding Standard](https://github.com/easy-coding-standard/easy-coding-standard) (ECS)** wrapper with a set of recommended rules.  
Provides an easy way to check and fix PHP code style both via CLI and programmatically.

- ✅ Framework-agnostic
- ✅ Built-in Laravel integration
- ✅ Pre-configured with popular coding standards
- ✅ Programmatic interface to check & fix code

---

## 📦 Installation

```bash
composer require justcoded/php-cs-fixer
```
for only CLI usage you could install as `dev` dependency
```bash
composer require justcoded/php-cs-fixer --dev
```

---

## 🚀 Usage

### CLI Usage

After installation, the package exposes the ECS binary:

```bash
# Check code style:
./vendor/bin/ecs check

# Automatically fix code style issues:
./vendor/bin/ecs check --fix
```

You can also specify paths:

```bash
./vendor/bin/ecs check path/to/your/files
```

---

### Programmatic Usage

The package provides the `JustCoded\PhpCsFixer\Services\CodeFixer` class to run checks and fixes within your PHP code.

#### Constructor

```php
new CodeFixer(array $config = [])
```

**Available Config Options:**

| Option | Type         | Default | Description                                                                                                               |
|-------|--------------|---------|---------------------------------------------------------------------------------------------------------------------------|
| `tty` | bool \| null | false   | Whether to enable TTY mode in the process. Useful for colored output. Uses `Process::isTtySupported()` if value set to null |

---

### Basic Example:

```php
use JustCoded\PhpCsFixer\Services\CodeFixer;

$fixer = new CodeFixer();

// Check mode
$result = $fixer->check();

if (! $result->successful) {
    echo "Code issues found:\n";
    echo $result->output;
}

// Fix mode
$result = $fixer->fix();
echo $result->output;
```

---

### Custom Paths & Config:

```php
use JustCoded\PhpCsFixer\Services\CodeFixer;

$fixer = new CodeFixer(config: ['tty' => true]);

// Check a specific path
$result = $fixer->check(path: ['app/', 'tests/']);

// Fix specific path with TTY disabled
$result = $fixer->fix(path: 'src/', config: ['tty' => false]);
```

---

### Advanced Usage - Direct `execute()`:

You can also use the more flexible `execute()` method:

```php
use JustCoded\PhpCsFixer\Services\CodeFixer;

$fixer = new CodeFixer();

$result = $fixer->execute(
    path: 'src/',
    fix: true,
    config: ['tty' => false],
    callback: function ($type, $buffer) {
        echo $buffer; // Stream process output
    },
);

echo $result->output;
```

---

### Result Object:

All methods return a `CodeFixerResult`:

```php
class CodeFixerResult
{
    public bool $successful;
    public string $output;
}
```

## ⚙️ Laravel Integration

When used in a Laravel project, this package provides **seamless integration** out of the box.

### Features:

- **Service Provider Auto-Discovery**  
  No manual registration is needed. The package auto-registers:

  ```php
  JustCoded\PhpCsFixer\Providers\PhpCsFixerServiceProvider
  ```

- **Configuration File**  
  After installation, the package publishes a configuration file:

  ```bash
  php artisan vendor:publish --tag=php-cs-fixer-config
  ```

  This creates `config/php-cs-fixer.php` containing:

  ```php
  return [
      /*
      | If null Symfony\Component\Process\Process::isTtySupported() is used.
      | You probably want it to be false to be able to capture the output.
      */
      'tty' => env('PHP_CS_FIXER_TTY', false),
  ];
  ```

  You can adjust the default `tty` behavior by changing this config or setting the `PHP_CS_FIXER_TTY` environment variable.

- **Service Container Binding**  
  The package registers the `CodeFixer` class as a **scoped singleton** within Laravel’s service container.

  You can easily inject it wherever needed:

  ```php
  use JustCoded\PhpCsFixer\Services\CodeFixer;

  public function __construct(
      protected CodeFixer $fixer,
  ) {}

  public function run()
  {
      $result = $this->fixer->check();
  
      echo $result->output;
  }
  ```

  Or resolve it manually:

  ```php
  $fixer = app(JustCoded\PhpCsFixer\Services\CodeFixer::class);
  ```

---

## 📚 Configured Standards

The package includes:

- **FriendsofPHP/php-cs-fixer**
- **Symplify Easy Coding Standard**
- **Slevomat Coding Standard**
- **PHP_CodeSniffer**
- **Custom fixers from kubawerlos/php-cs-fixer-custom-fixers**

It ships pre-configured with best-practice rules.  
However, you can override the configuration by placing your own `ecs.php` in the project root.

---

Here’s a clear and concise section you can add to the README to explain how users can provide a custom `ecs.php` config file:

---

## 🛠️ Custom `ecs.php` Configuration

By default, **PhpCsFixer** comes with a preconfigured `ecs.php` configuration file located inside the package. However, you can easily override this configuration by placing your own `ecs.php` file at the root of your project.

**How it works:**

- If a `ecs.php` file exists in your project's root directory, it will be automatically used when running `check` or `fix` commands (both CLI and programmatic usage).
- If no custom config is found, the package's default configuration will be applied.

### Example: Providing Custom `ecs.php`

1. Create a file in your project root:

```php
// ecs.php
<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->sets([
        \Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12,
    ]);
};
```

2. Run:

```bash
./vendor/bin/ecs check
```

Your custom rules and paths will now be applied.

---

**Note:**  
When using **Laravel integration**, the same behavior applies. You can manage your own `ecs.php` file without needing to modify the package. The `CodeFixer` service will detect and use your config automatically.

---

## 🧪 Testing

```bash
composer test
```

---

## 📝 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---
