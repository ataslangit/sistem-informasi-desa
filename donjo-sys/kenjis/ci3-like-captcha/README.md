# CodeIgniter3-like Captcha

This project provides CodeIgniter3-like Captcha.

- This is **not** 100% compatible with CI3's CAPTCHA Helper.
- This uses [php-simple-captcha](https://codeberg.org/S1SYPHOS/php-simple-captcha).

## Requirements

- PHP 7.4 or later

## Installation

```sh-session
$ composer require kenjis/ci3-like-captcha
```

## Usage

See <https://codeigniter.com/userguide3/helpers/captcha_helper.html>.

Instead of `create_captcha()`, use `Captcha::createCaptcha()`.

```php
use Kenjis\CI3Like\Captcha\Captcha;

$vals = [
    'word'      => random_string('numeric', 4),
    'img_path'  => FCPATH . 'captcha/',
    'img_url'   => base_url() . '/captcha/',
];
$cap = Captcha::createCaptcha($vals);

$data = [
    'captcha_id'   => '',
    'captcha_time' => $cap['time'],
    'word'         => $cap['word'],
];
```

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE`](LICENSE).
