# SCRU128 IDs for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grantholle/scru128-laravel.svg?style=flat-square)](https://packagist.org/packages/grantholle/scru128-laravel)
[![Tests](https://github.com/grantholle/scru128-laravel/actions/workflows/run-tests.yml/badge.svg)](https://github.com/grantholle/scru128-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/grantholle/scru128-laravel.svg?style=flat-square)](https://packagist.org/packages/grantholle/scru128-laravel)

Use [SCRU128](https://github.com/scru128/spec) identifiers as Eloquent primary keys, the same way you'd use Laravel's `HasUuids`. Built on [grantholle/scru128](https://github.com/grantholle/scru128).

SCRU128 IDs are 25-character, case-insensitive, time-sortable strings (`0372ijojuxuhjsfkeryi2mrtm`) with 128 bits of entropy.

## Installation

```bash
composer require grantholle/scru128-laravel
```

No configuration needed.

## Usage

```php
use GrantHolle\Scru128Laravel\Concerns\HasScru128Ids;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasScru128Ids;
}
```

```php
Schema::create('posts', function (Blueprint $table) {
    $table->scru128(); // char('id', 25)->primary()
    // ...
});

Schema::create('comments', function (Blueprint $table) {
    $table->scru128();
    $table->foreignScru128('post_id')->constrained();
});
```

`scru128($column = 'id')` and `foreignScru128($column)` are Blueprint macros; the foreign variant behaves like `foreignUuid()`.

On MySQL/MariaDB, IDs are lowercase base36, so an ASCII binary collation keeps the column and its indexes compact and makes comparisons cheaper:

```php
$table->scru128()->charset('ascii')->collation('ascii_bin');
$table->foreignScru128('post_id')->charset('ascii')->collation('ascii_bin')->constrained();
```

The trait sets `$incrementing = false` and `$keyType = 'string'`, fills the key on create, and makes route model binding 404 on malformed IDs, exactly like `HasUuids`. Override `uniqueIds()` to generate IDs for additional columns:

```php
public function uniqueIds(): array
{
    return ['id', 'public_id'];
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Grant Holle](https://github.com/grantholle)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
