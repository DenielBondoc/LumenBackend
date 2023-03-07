<?php

return[
    'driver' => env('MAIL_DRIVER', 'sendgrid'),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS'),
        'name' => env('MAIL_FROM_NAME')
    ],

    'mailers' => [
        'sendgrid' => [
            'transport' => 'sendgrid',
        ],
    ],
];