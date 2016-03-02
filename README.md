# sunlight-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


A limited PHP wrapper for the Sunlight Foundation APIs designed for use on contactmyreps.org

## Install

Via Composer

``` bash
$ composer require contactmyreps/sunlight-php
```

## Usage

``` php
$sunlight = new Sunlight('695e61a2595a4f5aa9122ee4225c8247');
$openStates = $sunlight->openStates();
$congress = $sunlight->congress();

//get all Alabama's state legislators
$states->legislators(
    [
        'state' => 'AL'
    ],
);

//get all State reps serving a gps coordinate
$states->geoLookup($lat, $lng);

//get all Congressional representatives serving an area
$congress->locateByZip(11111);
$congress->locateByGeo($lat, $lng);

$request methods can be passed an optional extra array argument of display fields to return (last_name, first_name, etc.)

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email edfialk@gmail.com instead of using the issue tracker.

## Credits

- [Ed Fialkowski][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/contactmyreps/sunlight-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/contactmyreps/sunlight-php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/contactmyreps/sunlight-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/contactmyreps/sunlight-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/contactmyreps/sunlight-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/contactmyreps/sunlight-php
[link-travis]: https://travis-ci.org/contactmyreps/sunlight-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/contactmyreps/sunlight-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/contactmyreps/sunlight-php
[link-downloads]: https://packagist.org/packages/contactmyreps/sunlight-php
[link-author]: https://github.com/edfialk
[link-contributors]: ../../contributors
