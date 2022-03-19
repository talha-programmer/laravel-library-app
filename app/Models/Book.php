<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function actionLogs()
    {
        return $this->hasMany(UserActionLog::class, 'book_id');
    }
}
