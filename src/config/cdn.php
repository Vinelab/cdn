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
    | The upload threshold
    |--------------------------------------------------------------------------
    |
    | the upload threshold by default = 10
    |
    */
    'threshold' => 10,

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

                'credentials' => [
                    'key'       => 'AKIAIUFQIM4L4543PZQAX', // fake
                    'secret'    => 'zoj7gqvvlvJV9lDGAn9mgAiwik55UlizjTgCWwgJB', // fake
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
//                    'your-main-bucket-name-here' => '*',
                    'megabucketzon' => '*',
                    //        'your-js-bucket-name-here'  =>  ['public/js'],
                    //        'your-css-bucket-name-here'  =>  ['public/css'],
                ],

                /*
                | The Access Control Lists.
                | Amazon S3 supports a set of predefined grants, known as canned ACLs.
                | Each canned ACL has a predefined a set of grantees and permissions.
                | The following list is a set of canned ACLs and the associated
                | predefined grants: private, public-read, public-read-write, authenticated-read
                | bucket-owner-read, bucket-owner-full-control, log-delivery-write
                */
                'acl' => 'public-read'

            ],

//            'cloudfront' => [
//
//                'credentials' => [
//                    'key'       => '',
//                    'secret'    => '',
//                ],
//
//            ],

        ],

//        'cloudflare' => [
//            'key'       => '',
//            'secret'    => '',
//        ],

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
        'directories'   => ['public'],
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
    | 'hidden' is a boolean to excludes "hidden" directories and files (starting with a dot)
    |
    */
    'exclude'    => [
        'directories'   => ['public/uploads'],
        'files'         => [''],
        'extensions'    => ['.txt'],
        'patterns'      => ['404.*'],
        'hidden'        => true,
    ],




];
