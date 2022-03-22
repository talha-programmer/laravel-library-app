<?php

namespace Tests\Feature;

use App\Enums\BookStatus;
use App\Models\User;
use App\Services\ActionLogService;
use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{

    public function test_isbn_validate_correctly()
    {
        // I don't know how to handle these dependencies in tests
        // that's why added like this
        $logService = new ActionLogService();
        $bookService = new BookService($logService);

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

    public function test_books_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/books');

        $response->assertStatus(200);
    }

    public function test_new_books_can_be_saved()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/books', [
            'title' => 'New Book',
            'isbn' => '0978153871',
            'published_at' => '1990-11-20',
            'status' => BookStatus::AVAILABLE->value,
        ]);

        $response->assertRedirect('/books');
        $response->assertSessionHas('success');
    }

}
