<?php

namespace App\Services;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\UserActionLog;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class BookService
{
  protected $logService;

  public function __construct(ActionLogService $logService)
  {
    $this->logService = $logService;
  }

  public function store(array $attributes): Book|bool
  {
    $title = $attributes["title"];
    $isbn = $attributes["isbn"];
    $published_at = $attributes["published_at"];
    $status = $attributes["status"];
    $status = BookStatus::from($status)->name;

    $book = new Book([
      'title' => $title,
      'isbn' => $isbn,
      'published_at' => $published_at,
      'status' => $status,
    ]);

    try {
      $book->save();
      return $book;
    } catch (Exception $exception) {
      return false;
    }
  }

  public function find(int $id): Book|bool
  {
    return Book::find($id);
  }

  public function destroy(int|Book $book): bool
  {
    $book = $this->getModel($book);
    try {
      DB::beginTransaction();
      $book->actionLogs()->delete();
      $book->delete();
      DB::commit();
      return true;
    } catch (Exception $exception) {
      DB::rollBack();
      return false;
    }
  }

  public function isValidIsbn(string $isbn): bool
  {
    $isbn = str_split($isbn);
    if (sizeof($isbn) !== 10) {
      return false;
    }
    $sum = 0;
    for ($i = 0; $i < 10; $i++) {
      $digit = (int)$isbn[$i];
      if (!is_integer($digit)) {
        return false;
      }
      $sum += (10 - $i) * $digit;
    }

    if ($sum % 11 === 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getAll(): Paginator
  {
    return Book::paginate(20);
  }

  public function isCheckedOut(int|Book $book): bool
  {
    $book = $this->getModel($book);
    if (!$book) {
      return false;
    }

    if ($book->status == BookStatus::CHECKED_OUT->value) {
      return true;
    } else {
      return false;
    }
  }

  public function isAvailable(int|Book $book): bool
  {
    $book = $this->getModel($book);
    if (!$book) {
      return false;
    }

    if ($book->status == BookStatus::AVAILABLE->value) {
      return true;
    } else {
      return false;
    }
  }

  public function checkin(int|Book $book): Book|bool
  {
    $book = $this->getModel($book);

    try {
      DB::beginTransaction();
      $book->status = BookStatus::AVAILABLE->name;
      $book->save();
      $userLogAttributes = [
        'book' => $book,
        'action' => "CHECKIN",
      ];
      $this->logService->store($userLogAttributes);
      DB::commit();
      return $book;
    } catch (Exception $exception) {
      DB::rollBack();
      return false;
    }
  }

  public function checkout(int|Book $book): Book|bool
  {
    $book = $this->getModel($book);

    try {
      DB::beginTransaction();
      $book->status = BookStatus::CHECKED_OUT->name;
      $book->save();

      $userLogAttributes = [
        'book' => $book,
        'action' => "CHECKOUT",
      ];
      $this->logService->store($userLogAttributes);

      DB::commit();
      return $book;

    } catch (Exception $exception) {
      DB::rollBack();
      return false;
    }
  }

  protected function getModel(int|Book $book): Book|bool
  {
    if (is_integer($book)) {
      $book = $this->find($book);
    }
    if (!$book) {
      return false;
    }

    return $book;
  }
}
