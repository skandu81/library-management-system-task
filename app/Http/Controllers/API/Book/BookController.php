<?php

namespace App\Http\Controllers\API\Book;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Book\BookListResource;
use App\Http\Resources\API\Book\BookDetailsResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('publisher')->get();

        return BookListResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $user = $request->user();

        $book = new Book();
        $book->title = $request->title;
        $book->author_name = $request->author_name;
        $book->description = $request->description;
        $book->added_by = $user->id;
        $book->quantity = $request->quantity;
        $book->save();

        return response()->json(['status' => true, 'message' => 'Book Save Successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookDetailsResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $user = $request->user();

        $book->title = $request->title;
        $book->author_name = $request->author_name;
        $book->description = $request->description;
        $book->added_by = $user->id;
        $book->quantity = $request->quantity;
        $book->update();

        return response()->json(['status' => true, 'message' => 'Book Updated Successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['status' => true, 'message' => 'Book Deleted Successfully.']);
    }
}
