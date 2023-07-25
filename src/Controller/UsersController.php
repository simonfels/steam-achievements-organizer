<?php

namespace App\Controller;
use App\Models\UsersList;

class UsersController extends AbstractController {
  private UsersList $users_list;

  public function __construct() {
    $this->users_list = new UsersList();
  }
  public function index(): void {
    $this->render('Users/index', [
      'users' => $this->users_list->all()
    ]);
  }

  public function show(): void {
    $user_id = @$_GET['userid'];

    if(!empty($user_id)) {
      $this->render('Users/show', [
        'user' => $this->users_list->find($user_id)
      ]);
    } else {
      $this->render('Users/404');
    }
  }

  public function activity(): void {
    $user_id = @$_GET['userid'];
    $date = @$_GET['date'];

    if(!empty($user_id)) {
      $this->render('Users/activity', [
        'user' => $this->users_list->find($user_id, $date),
        'show_date' => $date
      ]);
    } else {
      $this->render('Users/404');
    }
  }
}
