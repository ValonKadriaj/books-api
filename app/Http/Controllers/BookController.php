<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(['books' => Book::all()]);
    }

    public function store(ValidateBookRequest $request)
    {   
        $validated = $request->all();
        $validated['user_id'] = auth()->user()->id;
        $book = Book::create($validated);
        return response()->json(['success' => 'Book created successfully.', 'book' => $book]);
    }
 
    public function update(ValidateBookRequest $request,Book $book)
    {
        $book->update($request->all());
        return response()->json(['success' => 'Book has been updated successfully.', 'book' => $book]);
    }
    

   
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['success' => 'Book has been deleted successfully.']);
    }
}
