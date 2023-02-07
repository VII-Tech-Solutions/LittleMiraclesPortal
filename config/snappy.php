<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'binary' => env('SNAPPY_WKHTMLTOPDF', '/usr/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => env('SNAPPY_WKHTMLTOIMAGE', '/usr/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
        'env' => array(),
    ),
);
