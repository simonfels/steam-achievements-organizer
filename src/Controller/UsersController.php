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

  public function show(string $user_id, string|null $date = null): void {
    $this->render('Users/show', [
      'user' => $this->users_list->find($user_id),
      'date' => $date
    ]);
  }
}
