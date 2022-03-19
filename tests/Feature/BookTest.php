<?php

namespace Tests\Feature;

use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    protected $bookService;

    public function test_isbn_validate_correctly()
    {
        $bookService = new BookService();
        $validIsbnNumbers = [
            "0978194527",
            "0978194004",
            "0978039912",
            "0978125029",
            "0978153871"
        ];

        $invalidIsbnNumbers = [
            "0978131337",
            "0978194984",
            "0978419992",
            "097812133029",
            "097815ferew71"
        ];
        
        foreach ($validIsbnNumbers as $isbn ) {
            $isValid = $bookService->isValidIsbn($isbn);
            $this->assertTrue($isValid);
        }

        foreach ($invalidIsbnNumbers as $isbn ) {
            $isValid = $bookService->isValidIsbn($isbn);
            $this->assertFalse($isValid);
        }
    }
}