<?php

/**
 * PHPMaker 2021 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MSSQL", "qs" => "[", "qe" => "]", "host" => "192.168.1.234", "port" => "50201", "user" => "sa", "password" => "Agussalim7", "dbname" => "RSUD_BESEMAH_VCLAIM_V11"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "localhost", // SMTP server
        "SERVER_PORT" => 25, // SMTP server port
        "SECURE_OPTION" => "",
        "SERVER_USERNAME" => "", // SMTP server user name
        "SERVER_PASSWORD" => "", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "5lLtEA0l6KwwIeEe", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
