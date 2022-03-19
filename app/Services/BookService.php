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
    $isbn = str_split($isbn);
    if(sizeof($isbn) !== 10){
      return false;
    } 
    $sum = 0;
    for ($i=0; $i < 10; $i++) { 
      $digit = (int)$isbn[$i];
      if(!is_integer($digit)){
        return false;
      }
      $sum += (10 - $i) * $digit;
    }

    if($sum % 11 === 0){
      return true;
    } else {
      return false;
    }
  }

  public function getAll():Paginator
  {
    return Book::all()->paginate(20);
  }
}
