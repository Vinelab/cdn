<?php

// IMPORTANT! Beware remove any of the configuration parameters would break functionality

return [


    /*
    |--------------------------------------------------------------------------
    | CDN default provider
    |--------------------------------------------------------------------------
    |
    | Specify the default CDN provider, to be used in the application
    |
    */
    'default' => 'aws-s3',

    /*
    |--------------------------------------------------------------------------
    | CDN Providers Info
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'providers' => [

        'aws-s3' => [
            /*
            | Enter the CDN credentials here, to allow the application to
            | upload your assets.
            |
            */
            'access_key'    => '',
            'secret_key'    => '',

        ],


        'Cloudflare' => [

            'KEY'    => '',
            'SECRET' => '',

        ]



    ],


    /*
    | Specify which directories you want to include, for upload when
    | running the [php artisan cdn:push]
    |
    | Enter the full path of directories and/or files (starting from the public
    | directory as the root).
    |
    */
    'include'    => ['public', 'private'],


    /*
    | Specify what to exclude from the above 'include' when uploading
    | to the CDN.
    |
    | Enter the full path of directories and/or files (starting from the public
    | directory as the root).
    |
    */
    'exclude'    => [
        'directories'   => [''],
        'files'         => ['README.md', 'LICENSE'],
        'extensions'    => ['.txt'],
        'pattern'       => '404.*'
    ],




    /*
    | Set only the CDN url here.
    |
    */
    'url' => 'https://s3.amazonaws.com',



    /*
    | If you want all your 'included' assets to be uploaded to one bucket,
    | then set your bucket name next to the '*'.

    | And if you have multiple buckets (each for a specific directory),
    | then you need to specify which directories need to uploaded to
    | which buckets.
    |
    | * Note: in case of multiple buckets remove the '*'.
    |
    */
    'buckets' => [
        'your-main-bucket-name-here' => '*',
//        'your-js-bucket-name-here'  =>  ['public/js'],
//        'your-css-bucket-name-here'  =>  ['public/css'],
    ],







];