# Laravel CDN Assets Manager

[![Total Downloads](https://poser.pugx.org/vinelab/cdn/downloads)](https://packagist.org/packages/vinelab/cdn) 
[![Latest Stable Version](https://poser.pugx.org/vinelab/cdn/v/stable)](https://packagist.org/packages/vinelab/cdn) 
[![Latest Unstable Version](https://poser.pugx.org/vinelab/cdn/v/unstable)](https://packagist.org/packages/vinelab/cdn) 
[![Build Status](https://travis-ci.org/Vinelab/cdn.svg)](https://travis-ci.org/Vinelab/cdn)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Vinelab/cdn/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Vinelab/cdn/?branch=master)
[![License](https://poser.pugx.org/vinelab/cdn/license)](https://packagist.org/packages/vinelab/cdn)


##### Content Delivery Network Package for Laravel

The package provides the developer the ability to upload his assets (or any public file) to a CDN with a single artisan command.
And then it allows him to switch between the local and the online version of the files.

#### Laravel Support
- For Laravel 5.1 use the latest realease (`master`).
- For Laravel 4.2 use the realease `v1.0.1` [Last suport for L 4.2](https://github.com/Vinelab/cdn/releases/tag/v1.0.1)

## Highlights

- Amazon Web Services - S3
- Artisan command to upload content to CDN
- Simple Facade to access CDN assets



## Installation

#### Via Composer

Require `vinelab/cdn` in your project:

```bash 
composer require vinelab/cdn:*
```

*Since this is a Laravel package we need to register the service provider:*

Add the service provider to `config/app.php`:

```php
'providers' => array(
     //...
     Vinelab\Cdn\CdnServiceProvider::class,
),
```

## Configuration

Set the Credentials in the `.env` file.

*Note: you must have an `.env` file at the project root, to hold your sensitive information.*

```bash
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
```

Publish the package config file:

```bash
php artisan vendor:publish vinelab/cdn
```

You can find it at `config/cdn.php`


##### Default Provider
```php
'default' => 'AwsS3',
```

##### CDN Provider Configuration

```php
'aws' => [

    's3' => [
    
        'version'   => 'latest',
        'region'    => '',

        'buckets' => [
            'my-backup-bucket' => '*',
        ]
    ]
],
```

###### Multiple Buckets

```php
'buckets' => [

    'my-default-bucket' => '*',
    
    // 'js-bucket' => ['public/js'],
    // 'css-bucket' => ['public/css'],
    // ...
]

```

#### Files & Directories

###### Include:

Specify directories, extensions, files and patterns to be uploaded.

```php
'include'    => [
    'directories'   => ['public/dist'],
    'extensions'    => ['.js', '.css', '.yxz'],
    'patterns'      => ['**/*.coffee'],
],
```

###### Exclude:

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

##### URL

Set the CDN URL:

```php
'url' => 'https://s3.amazonaws.com',
```

##### Bypass

To load your LOCAL assets for testing or during development, set the `bypass` option to `true`:

```php
'bypass' => true,
```

##### Cloudfront Support

```php
'cloudfront'    => [
    'use' => false,
    'cdn_url' => ''
],
```


##### Other Configurations

```php
'acl'           => 'public-read',
'metadata'      => [ ],
'expires'       => gmdate("D, d M Y H:i:s T", strtotime("+5 years")),
'cache-control' => 'max-age=2628000',
```

You can always refer to the AWS S3 Documentation for more details: [aws-sdk-php](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/)

## Usage

#### Push

Upload assets to CDN
```bash
php artisan cdn:push
```
#### Empty

Delete assets from CDN
```bash
php artisan cdn:empty
```

#### Load Assets

Use the facade `Cdn` to call the `Cdn::asset()` function.

*Note: the `asset` works the same as the Laravel `asset` it start looking for assets in the `public/` directory:*

```blade
{{Cdn::asset('assets/js/main.js')}}        // example result: https://js-bucket.s3.amazonaws.com/public/assets/js/main.js

{{Cdn::asset('assets/css/style.css')}}        // example result: https://css-bucket.s3.amazonaws.com/public/assets/css/style.css
```

To use a file from outside the `public/` directory, anywhere in `app/` use the `Cdn::path()` function:

```blade
{{Cdn::path('private/something/file.txt')}}        // example result: https://css-bucket.s3.amazonaws.com/private/something/file.txt
```












## Test

To run the tests, run the following command from the project folder.

```bash
$ ./vendor/bin/phpunit
```

## Support

[On Github](https://github.com/Vinelab/cdn/issues)


## Contributing

Please see [CONTRIBUTING](https://github.com/Vinelab/cdn/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mahmoud@vinelab.com instead of using the issue tracker.

## Credits

- [Mahmoud Zalt](https://github.com/Mahmoudz)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/Vinelab/cdn/blob/master/LICENSE) for more information.


