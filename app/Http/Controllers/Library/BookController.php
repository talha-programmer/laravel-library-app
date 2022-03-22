<?php

namespace App\Http\Controllers\Library;

use App\Enums\BookStatus;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\StoreBook;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function form()
    {
        $statusEnums = BookStatus::cases();
        return Inertia::render('Library/BookForm', [
            'statusEnums' => $statusEnums,
        ]);
    }

    public function index()
    {
        $books = $this->bookService->getAll();
        return Inertia::render('Library/Books', [
            'books' => $books
        ]);
    }

    public function store(StoreBook $request)
    {
        $isbn = $request->isbn;
        $isValidIsbn = $this->bookService->isValidIsbn($isbn);

        if (!$isValidIsbn) {
            throw ValidationException::withMessages([
                'isbn' => "Invalid ISBN number provided",
            ]);
        } else {
            $bookAttribues = $request->all();
            $isSaved = $this->bookService->store($bookAttribues);

            if ($isSaved) {
                return redirect(route('books'))
                    ->with('status', 'Book saved successfully.');
            } else {
                return response()->json(['error']);
            }
        }
    }

    public function destroy(Request $request, Book $book)
    {
        $isDeleted = $this->bookService->destroy($book);
        if ($isDeleted) {
            return back()->with('success', "Book deleted.");
        } else {
            return back()->with('error', "Error occurred while deleting book.");
        }
    }

    public function checkin(Request $request, Book $book)
    {
        $isCheckedOut = $this->bookService->isCheckedOut($book);

        if (!$isCheckedOut) {
            return back()->with('error', 'Book already checked in.');
        }

        $checkin = $this->bookService->checkin($book);
        if ($checkin) {
            return redirect(route('books'))->with('success', 'Checkin successfull.');
        }
        return back()->with('error', 'Error occurred while checkin.');
    }

    public function checkout(Request $request, Book $book)
    {
        $isAvailable = $this->bookService->isAvailable($book);

        if (!$isAvailable) {
            return back()->with('error', 'Book already checked out.');
        }

        $checkout = $this->bookService->checkout($book);
        if ($checkout) {
            return redirect(route('books'))->with('success', 'Checkout successfull.');
        }
        return back()->with('error', 'Error occurred while checkout.');
    }
}
