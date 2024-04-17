<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'uploaddirectory' =>__DIR__. '/../public/uploads', // upload directory

// Renderer settings
'renderer' => [
    'templatepath' =>__DIR__ . '/../templates/',
    ],

    // Database connection settings
    "db" => [
    "host" => "localhost",
    "dbname" => "car",
    "user" => "root",
    "pass" => "",
    ]
],
];