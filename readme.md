
# CDN Assets Manager

[![Build Status](https://travis-ci.org/thephpleague/statsd.png?branch=master)](https://travis-ci.org/Vinelab/cdn)
[![Total Downloads](https://poser.pugx.org/league/statsd/downloads.png)](https://packagist.org/packages/vinelab/cdn)
Content Delivery Network Package for Laravel 4

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

Publish the default config using `php artisan config:publish vinelab/cdn` and check it out at `app/config/packages/vinelab/cdn/cdn.php`

In case you would like to have environment-based configuration `app/config/packages/vinelab/cdn/[ENV]/cdn.php`

### Providers

Supported Providers:

- Amazon Web Services - S3 (Default)

#### Default Provider
```php
'default' => 'aws-s3',
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

Set the URL protocol:

```php
    'protocol' => 'https',
```

Set the CDN domain:

```php
    'domain' => 's3.amazonaws.com',
```

#### Threshold
Determines how many files to be uploaded concurrently.

> Will clear the buffer when the `threshold` has been reached, be careful when setting this to a high value
not to exceed what you have allowed in your PHP configuration.

```php
    'threshold' => 10,
```

## Usage

### Push

Upload your assets with `php artisan cdn:push`

### Load Assets

Since the service provider of this package aliases itself as the facade `Cdn` you may use it as such:

```blade
    {{Cdn::asset('public/index.php')}}
    // https://default-bucket.s3.amazonaws.com/public/index.php

    {{Cdn::asset('public/assets/js/main.js')}}
    // https://js-bucket.s3.amazonaws.com/public/assets/js/main.js

    {{Cdn::asset('public/assets/css/main.css')}}
    // https://css-bucket.s3.amazonaws.com/public/assets/css/main.css
```

## Contributing

Please see [CONTRIBUTING](https://github.com/Vinelab/cdn/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/Vinelab/cdn/blob/master/LICENSE) for more information.
