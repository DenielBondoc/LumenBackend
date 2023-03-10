<?php

return[
    'driver' => env('MAIL_DRIVER', 'sendgrid'),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'itsmesendgrid@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Jandeniel')
    ],

    'mailers' => [
        'sendgrid' => [
            'transport' => 'sendgrid',
        ],
    ],
];