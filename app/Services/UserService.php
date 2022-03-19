<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

class UserService
{

  public function find(int $id): User|bool
  {
    return User::find($id);
  }

  public function destroy(int $id): bool
  {
    return false;
  }

  public function getAll(): Paginator
  {
    User::all()->paginate(20);
  }
}
