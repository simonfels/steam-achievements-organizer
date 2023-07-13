<?php

namespace App\Controller;
use App\Models\UsersList;

class UsersController extends AbstractController {
  private UsersList $users_list;

  public function __construct() {
    $this->users_list = new UsersList();
  }
  public function index():void {
    $this->render('Users/index', [
      'users' => $this->users_list->all()
    ]);
  }
}
