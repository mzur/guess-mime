# Guess MIME

[![Tests](https://github.com/mzur/guess-mime/actions/workflows/php.yml/badge.svg)](https://github.com/mzur/guess-mime/actions/workflows/php.yml)

Guess the MIME type from the file extension (Linux only). This can be handy if the file does not exist or cannot be accessed.

**Warning:** This package should not be used if the file actually exists and can be accessed (e.g. to check user-uploaded files). Use [`finfo_file`](https://www.php.net/manual/en/function.finfo-file.php) for that.

## Installation

```
composer require mzur/guess-mime
```

## Usage

```php
use Mzur\GuessMIME\GuessMIME;

$gm = new GuessMIME;
$mime = $gm->guess('image.jpg');
var_dump($mime); // image/jpeg
```

If a MIME type cannot be guessed, `application/octet-stream` is returned. You can also limit the available MIME types, use a different MIME type database file (default: `/etc/mime.types`) and use a strict check that returns `null` if the MIME type cannot be guessed:

```php
use Mzur\GuessMIME\GuessMIME;

// Limit detection to image/jpeg and use a different database file.
$gm = new GuessMIME(['image/jpeg'], '/home/user/.mime.types');

// Default MIME type.
$mime = $gm->guess('image.png');
var_dump($mime); // application/octet-stream

// Use strict check.
$mime = $gm->guess('image.png', true);
var_dump($mime); // null
```
