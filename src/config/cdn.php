<?php

// IMPORTANT! Beware remove any of the configuration parameters would break functionality

return [

    /*
    |--------------------------------------------------------------------------
    | Default CDN provider name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the CDN providers below you wish
	| to use as your default provider for all CDN work.
    |
    */
    'default' => 'aws.s3',


    /*
    |--------------------------------------------------------------------------
    | Set the CDN url. (without the bucket name)
    |--------------------------------------------------------------------------
    |
    */
    'url' => 'https://s3.amazonaws.com',

    /*
    |--------------------------------------------------------------------------
    | CDN Providers
    |--------------------------------------------------------------------------
    |
	| Here are each of the CDN providers setup for your application.
	| Of course, examples of configuring each provider platform that is
	| supported by Laravel is shown below to make development simple.
    |
    */
    'providers' => [

        'aws' => [

            's3' => [
                'access_key'    => '111',
                'secret_key'    => '222',
            ],

            'cloudfront' => [
                'access_key'    => '',
                'secret_key'    => '',
            ],

            /*
            | If you want all your 'included' assets to be uploaded to one bucket,
            | then set your bucket name below.
            |
            | And if you have multiple buckets (each for a specific directory),
            | then you need to specify each bucket and it's directories
            |
            | * Note: in case of multiple buckets remove the '*'.
            |
            */
            'buckets' => [
                  'your-main-bucket-name-here' => '*',
        //        'your-js-bucket-name-here'  =>  ['public/js'],
        //        'your-css-bucket-name-here'  =>  ['public/css'],
            ],

        ],

        'cloudflare' => [
            'access_key'    => '',
            'secret_key'    => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Include
    |--------------------------------------------------------------------------
    |
    | Specify which directories to be uploaded when running the
    | [$ php artisan cdn:push] command
    |
    | Enter the full paths of directories (starting from the application root).
    |
    */
    'include'    => [
        'directories'   => ['public', 'private'],
        'files'         => [''],
        'extensions'    => [''],
        'patterns'      => [''],
    ],

    /*
    |--------------------------------------------------------------------------
    | Exclude
    |--------------------------------------------------------------------------
    |
    | Specify what to exclude from the 'include' directories when uploading
    | to the CDN.
    |
    */
    'exclude'    => [
        'directories'   => ['public/uploads'],
        'files'         => ['README.md', 'LICENSE'],
        'extensions'    => ['.txt'],
        'patterns'      => ['404.*'],
    ],




];