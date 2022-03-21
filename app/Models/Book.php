<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'isbn',
        'published_at',
        'status',
    ];

    /**
     * Get the value of the book status from BookStatus enum
     */
    public function status(): Attribute
    {
        $enumArray = [];
        $enums = BookStatus::cases();
        foreach ($enums as $enum ) {
            $enumArray[$enum->name] = $enum->value;
        }
        return Attribute::make(
            get: function ($value) use($enumArray) {
                return $enumArray[$value];
            }
        );
    }

    public function actionLogs()
    {
        return $this->hasMany(UserActionLog::class, 'book_id');
    }
}
