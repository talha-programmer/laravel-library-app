<?php

namespace App\Services;

use App\Models\Book;
use Brick\Math\BigInteger;
use Illuminate\Contracts\Pagination\Paginator;

class BookService
{
  public function store(array $attributes): Book|bool
  {
    return false;
  }

  public function find(int $id): Book|bool
  {
    return Book::find($id);
  }

  public function destroy(int $id):bool
  {
    return false;
  }

  public function isValidIsbn(string $isbn): bool
  {
    return false;
  }

  public function getAll():Paginator
  {
    return Book::all()->paginate(20);
  }
}
