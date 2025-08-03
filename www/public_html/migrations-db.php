<?php

extract(json_decode(file_get_contents(__DIR__ . '/.env'), true));

return [
    'dbname' => $dbname,
    'user' => $username,
    'password' => $password,
    'host' => $servername,
    'driver' => 'pdo_mysql',
];
