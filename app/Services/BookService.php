<?php

namespace App\Services;

use App\Enums\BookStatus;
use App\Models\Book;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class BookService
{
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
    if(is_int($book)){
      $book = self::find($book);
    }
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
}
