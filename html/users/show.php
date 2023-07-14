<?php

include_once __DIR__ . '/../../src/autoloader.php';

$user_id = @$_GET['userid'];

if(!empty($user_id)) {
  $users_controller = new App\Controller\UsersController();
  $users_controller->show($user_id);
} else {
  echo "<p>Parameter 'userid' muss gesetzt sein</p><br>";
  echo "<a href='/users'>Zurück</a>";
}
