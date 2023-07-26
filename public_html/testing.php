<?php

include_once "../src/autoloader.php";

extract(json_decode(file_get_contents(__DIR__ . '/../src/.env'), true));

var_dump($servername);