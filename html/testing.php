<?php
$zone = new DateTimeZone('Europe/Berlin');
$datetime = DateTime::createFromFormat('U', time());
$datetime->setTimezone($zone);
var_dump($datetime->getOffset());