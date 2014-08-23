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
    'default' => 'AWS-S3',

    /*
    |--------------------------------------------------------------------------
    | CDN Providers Info
    |--------------------------------------------------------------------------
    |
    | Here are each of the providers credentials setup.
    |
    */

    'providers' => [

        'AWS-S3' => [

            'ACCESS_KEY_ID'    => '',
            'SECRET_KEY' => '',

            'default_bucket' => ''

        ],

        'Cloudflare' => [

            'KEY'    => '',
            'SECRET' => '',

        ]



    ]




];