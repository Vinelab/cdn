
# CDN Assets Manager 

[![Build Status](https://travis-ci.org/thephpleague/statsd.png?branch=master)](https://travis-ci.org/Vinelab/cdn)

Content Delivery Network (CDN) Package  for Laravel 4

>This package will upload assets to CDN, (using artisan command).
The package has special helpers for including assets in code, the helpers withh automatically point to the CDN files.

----------

## Install

Via Composer

Add the package to your `composer.json` and run `composer update`.

```json
{
    "require": {
        "vinelab/cdn": "*"
    }
}
```

Add the service provider in `app/config/app.php`:

```php
'Vinelab\Cdn\CdnServiceProvider',
```

The service provider will register all the required classes for this package and will also alias
the `Cdn` class to `CdnFacadeProvider` so you can simply use the `Cdn` facade anywhere in your app.

## Configuration
in `app/config/cdn.php` or in case of an environment-based configuration `app/config/[env]/cdn.php`.

```php
'default' => 'aws-s3',
```

Add the CDN credentials:

```php

        'aws' => [

            's3' => [

                'credentials' => [
                    'access_key'    => '',
                    'secret_key'    => '',
                ],

            ],

```

Specify which directories or/and files to be uploaded:

```php
    'include'    => [
        'directories'   => ['public'],
        'extensions'    => [''],
        'patterns'      => [''],
    ],
```

Specify what to ignore from the 'include' directories:
```php
    'exclude'    => [
        'directories'   => ['public/uploads'],
        'files'         => ['README.md', 'LICENSE'],
        'extensions'    => ['.txt'],
        'patterns'      => ['404.*'],
        'hidden'        => true,
    ],
```
Set the CDN url:

```php
    'url' => 'https://s3.amazonaws.com',
```

Set your bucket/buckets name:

```php
    'buckets' => [
        'your-main-bucket-name-here' => '*',
//      'your-js-bucket-name-here'   =>  ['public/js'],
//      'your-css-bucket-name-here'  =>  ['public/css'],
    ],
```


## Usage


```shell
php artisan cdn:push
```
Simply just run this artisan command to upload all your `files` to the `CDN`.


## Testing

``` bash
$ phpunit
```


## Contributing

Please see [CONTRIBUTING](https://github.com/Vinelab/cdn/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/Vinelab/cdn/blob/master/LICENSE) for more information.
