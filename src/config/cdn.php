<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Bypass loading assets from the CDN
    |--------------------------------------------------------------------------
    |
    | This option determines whether to load the assets from localhost or from
    | the CDN server. (this is useful during development).
    | Set it to "true" to load from localhost, or set it to "false" to load
    | from the CDN (on production).
    |
    | Default: false
    |
    */

    'bypass' => false,

    /*
    |--------------------------------------------------------------------------
    | Default CDN provider
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the CDN providers below you wish
	| to use as your default provider for all CDN work.
    |
    | Supported provider: Amazon S3 (AwsS3)
    |
    */
    'default' => 'AwsS3',

    /*
    |--------------------------------------------------------------------------
    | CDN URL
    |--------------------------------------------------------------------------
    |
    | Set your CDN url, [without the bucket name]
    |
    */
    'url' => 'https://s3.amazonaws.com',

    /*
    |--------------------------------------------------------------------------
    | Threshold
    |--------------------------------------------------------------------------
    |
    | Define the number of files to allow in the queue before a flush.
    | Automatically flush the batch when the size of the queue reaches
    | the defined threshold value.
    |
    | Default = 10
    |
    */
    'threshold' => 10,

    /*
    |--------------------------------------------------------------------------
    | CDN Supported Providers
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
                    'key'       => '',
                    'secret'    => '',
                ],

                /*
                |--------------------------------------------------------------------------
                | CDN Bucket
                |--------------------------------------------------------------------------
                |
                | If you want all your assets to be uploaded to one bucket,
                | then set your bucket name below. 'your-bucket-name-here'
                |
                | And if you have multiple buckets (each for a specific directory),
                | then you need to specify each bucket and it's directories.
                |
                | * Note: in case of multiple buckets remove the '*'
                |
                */
                'buckets' => [
                    'bucket-name' => '*',
                    //        'your-js-bucket-name-here'   =>  ['public/js'],
                    //        'your-css-bucket-name-here'  =>  ['public/css'],
                ],

                /*
                |--------------------------------------------------------------------------
                | Access Control Lists (ACL)
                |--------------------------------------------------------------------------
                |
                | Amazon S3 supports a set of predefined grants, known as canned ACLs.
                | Each canned ACL has a predefined a set of grantees and permissions.
                | The following list is a set of canned ACLs and the associated
                | predefined grants: private, public-read, public-read-write, authenticated-read
                | bucket-owner-read, bucket-owner-full-control, log-delivery-write
                */
                'acl' => 'public-read',

                /*
                |--------------------------------------------------------------------------
                | Use CloudFront as the CDN
                |--------------------------------------------------------------------------
                |
                | Amazon S3 can be linked to CloudFront through distributions. This allows
                | the files in your S3 buckets to be served from a number of global
                | locations to achieve low latency and faster page load times.
                */
                'cloudfront' => [
                    'use'       => false,
                    'cdn_url'   => '',
                    'version'   => '',
                ],

                /*
                |--------------------------------------------------------------------------
                | Add metadata to each s3 file
                |--------------------------------------------------------------------------
                |   Add metadata to each s3 file
                */
                'metadata' => [],

                /*
                |--------------------------------------------------------------------------
                | Add expiry data to file
                |--------------------------------------------------------------------------
                |   Add expiry data to file
                */
                'expires' => gmdate("D, d M Y H:i:s T", strtotime("+5 years")),

                /*
                |--------------------------------------------------------------------------
                | Add browser level cache
                |--------------------------------------------------------------------------
                |   Add browser level cache
                */
                'cache-control' => 'max-age=2628000',

            ],

        ],

//        'cloudflare' => [
//            'key'       => '',
//            'secret'    => '',
//        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Files to Include
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
        'extensions'    => [],
        'patterns'      => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Files to Exclude
    |--------------------------------------------------------------------------
    |
    | Specify what to exclude from the 'include' directories when uploading
    | to the CDN.
    |
    | 'hidden' is a boolean to excludes "hidden" directories and files (starting with a dot)
    |
    */
    'exclude'    => [
        'directories'   => [],
        'files'         => [],
        'extensions'    => [],
        'patterns'      => [],
        'hidden'        => true,
    ],

];
