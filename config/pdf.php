<?php

return [
    'default' => 'dompdf',

    'dompdf' => [
        'mode' => '',
        'enable_font_subsetting' => false,
        'font_path' => storage_path('fonts/'),
        'font_data' => [
        ],
    ],

    'imagick' => [],

    'log_output_file' => storage_path('logs/pdf.log'),
];
