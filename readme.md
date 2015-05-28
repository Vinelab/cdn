# CDN Assets Manager

[![Total Downloads](https://poser.pugx.org/vinelab/cdn/downloads)](https://packagist.org/packages/vinelab/cdn) 
[![Latest Stable Version](https://poser.pugx.org/vinelab/cdn/v/stable)](https://packagist.org/packages/vinelab/cdn) 
[![Latest Unstable Version](https://poser.pugx.org/vinelab/cdn/v/unstable)](https://packagist.org/packages/vinelab/cdn) 
[![Build Status](https://travis-ci.org/Vinelab/cdn.svg?branch=master)](https://travis-ci.org/Vinelab/cdn)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Vinelab/cdn/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Vinelab/cdn/?branch=master)
[![License](https://poser.pugx.org/vinelab/cdn/license)](https://packagist.org/packages/vinelab/cdn)


Content Delivery Network Package for Laravel

Upload static assets of your choice to a CDN and have the file paths replaced with full URLs.
----------











## Install

### Via Composer

- Add the package to your `composer.json` and run `composer update`

    ```json
    {
        "require": {
            "vinelab/cdn": "*"
        }
    }
    ```

- Add the service provider to `app/config/app.php`:

    ```php
    'providers' => array(
        '...',
        'Vinelab\Cdn\CdnServiceProvider',
        '...'
    ),
    ```

The service provider will register all the required classes for this package and will also alias
the `Cdn` class to `CdnFacadeProvider` so you can simply use the `Cdn` facade anywhere in your app.

## Configuration

Publish the package config file:
```dos
php artisan config:publish vinelab/cdn
```
and check it out at `app/config/packages/vinelab/cdn/cdn.php`

In case you would like to have environment-based configuration `app/config/packages/vinelab/cdn/[ENV]/cdn.php`

### Providers

Supported Providers:

- Amazon Web Services - S3 (Default)

#### Default Provider
```php
'default' => 'AwsS3',
```

#### CDN Provider Setup

```php
    'aws' => [

        's3' => [

            'credentials' => [
                'key'    => '',
                'secret'    => '',
            ],

            'buckets' => [
                'my-backup-bucket' => '*',
            ]
        ]
    ],
```

##### Multiple Buckets

```php
'buckets' => [

    'my-default-bucket' => '*',
    'js-bucket' => ['public/js'],
    'css-bucket' => ['public/css'],
    '...'
]

```

### Files & Directories

#### Include

Specify directories, extensions, files and patterns to be uploaded.

```php
    'include'    => [
        'directories'   => ['public/dist'],
        'extensions'    => ['.js', '.css', '.yxz'],
        'patterns'      => ['**/*.coffee'],
    ],
```

#### Exclude

Specify what to be ignored.

```php
    'exclude'    => [
        'directories'   => ['public/uploads'],
        'files'         => [''],
        'extensions'    => ['.TODO', '.txt'],
        'patterns'      => ['src/*', '.idea/*'],
        'hidden'        => true, // ignore hidden files
    ],
```

#### URL

Set the CDN URL:

```php
    'url' => 'https://s3.amazonaws.com',
```

#### Threshold
Determines how many files to be uploaded concurrently.

> Will clear the buffer when the `threshold` has been reached, be careful when setting this to a high value
not to exceed what you have allowed in your PHP configuration.

```php
    'threshold' => 10,
```

#### Bypass

To load your local assets (not the CDN assets) for testing or during development, set the `bypass` option to `true`:

```php
    'bypass' => true,
```
## Usage

### Push

Upload your assets with
```dos
php artisan cdn:push
```
### Empty

Delete all of your assets remotely with
```dos
php artisan cdn:empty
```
### Load Assets

Now you can use the facade `Cdn` to call the `Cdn::asset()` function.
Note: the `asset` works the same as the Laravel `asset` it start looking for assets in the `public/` directory:

```blade
    {{Cdn::asset('assets/js/main.js')}}
    // https://js-bucket.s3.amazonaws.com/public/assets/js/main.js

    {{Cdn::asset('assets/css/main.css')}}
    // https://css-bucket.s3.amazonaws.com/public/assets/css/main.css
```

If you want to use a file from outside the `public/` directory anywhere in `app/` you can use the `Cdn::path()` function to do that:

```blade
    {{Cdn::path('public/assets/js/main.js')}}
    // https://js-bucket.s3.amazonaws.com/public/assets/js/main.js

    {{Cdn::path('private/something/file.txt')}}
    // https://css-bucket.s3.amazonaws.com/private/something/file.txt
```












## Contributing

Please see [CONTRIBUTING](https://github.com/Vinelab/cdn/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mahmoud@vinelab.com instead of using the issue tracker.

## Credits

- [Mahmoud Zalt](https://github.com/Mahmoudz)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/Vinelab/cdn/blob/master/LICENSE) for more information.


