<?php

namespace App\Services;

use App\Models\UserActionLog;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;

class ActionLogService
{

  public function find(int $id): UserActionLog|bool
  {
    return UserActionLog::find($id);
  }

  public function store(array $attributes): UserActionLog|bool
  {
    $user = auth()->user();
    $book = $attributes["book"];
    $action = $attributes["action"];

    try {
      $actionLog = new UserActionLog();
      $actionLog->user()->associate($user);
      $actionLog->book()->associate($book);
      $actionLog->action = $action;
      $actionLog->save();
      return $actionLog;

    } catch (Exception $exception) {
      throw $exception;
      return false;
    }
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
