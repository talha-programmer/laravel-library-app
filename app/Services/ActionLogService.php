<?php

namespace App\Services;

use App\Models\UserActionLog;
use Illuminate\Contracts\Pagination\Paginator;

class ActionLogService
{

  public function find(int $id): UserActionLog|bool
  {
    return UserActionLog::find($id);
  }

  public function store(array $attributes): UserActionLog|bool
  {
    return false;
  }

  public function destroy(int $id): bool
  {
    return false;
  }

  public function getAll(): Paginator
  {
    return UserActionLog::all()->paginate(20);
  }
}
