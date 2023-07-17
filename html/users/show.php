<?php

include_once __DIR__ . '/../../src/autoloader.php';

$user_id = @$_GET['userid'];
$date = @$_GET['date'];

if(!empty($user_id)) {
  $users_controller = new App\Controller\UsersController();
  $users_controller->show($user_id, $date);
} else {
  echo "<p>Parameter 'userid' muss gesetzt sein</p><br>";
  echo "<a href='/users'>Zurück</a>";
}
