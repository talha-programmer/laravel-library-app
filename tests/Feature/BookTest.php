<?php

namespace Tests\Feature;

use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;        
    }

    public function test_isbn_validate_correctly()
    {
        $validIsbnNumbers = [
            "0978194527",
            "0978194004",
            "0978039912",
            "0978125029",
            "0978153871"
        ];

        $invalidIsbnNumbers = [
            "0978131327",
            "0978194284",
            "0978419912",
            "097812135029",
            "097815fewrew71"
        ];
        
        foreach ($validIsbnNumbers as $isbn ) {
            $isValid = $this->bookService->isValidIsbn($isbn);
            $this->assertTrue($isValid);
        }

        foreach ($invalidIsbnNumbers as $isbn ) {
            $isValid = $this->bookService->isValidIsbn($isbn);
            $this->assertFalse($isValid);
        }
    }
}
