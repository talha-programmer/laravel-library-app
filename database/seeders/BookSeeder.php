<?php

namespace Database\Seeders;

use App\Enums\BookStatus;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $valid_isbns = [
            '0005534186',
            '0978110196',
            '0978108248',
            '0978194527',
            '0978194004',
            '0978194985',
            '0978171349',
            '0978039912',
            '0978031644',
            '0978168968',
            '0978179633',
            '0978006232',
            '0978195248',
            '0978125029',
            '0978078691',
            '0978152476',
        ];

        for ($i=0; $i < 20; $i++) { 
            $index = rand(0, 15);
            $isbn = $valid_isbns[$index];
            $title = "Book No " . $i+1;
            $status = BookStatus::AVAILABLE->name;
            $published_at = '2008-10-11';

            Book::create([
                'isbn' => $isbn,
                'title' => $title,
                'status' => $status,
                'published_at' => $published_at,
            ]);
        }

    }
}
