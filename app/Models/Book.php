<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'isbn',
        'published_at',
    ];

    protected $casts = [
        'status' => BookStatus::class,
    ];

    public function actionLogs()
    {
        return $this->hasMany(UserActionLog::class, 'book_id');
    }
}
