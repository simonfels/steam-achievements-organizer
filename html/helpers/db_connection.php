<?php

extract([
  'servername' => 'db',
  'username' => 'root',
  'dbname' => 'playground_development',
  'password' => 'rootpassword'
]);

$pdo = new PDO("mysql:host=$servername;dbname={$dbname}", $username, $password, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
