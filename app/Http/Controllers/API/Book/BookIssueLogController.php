<?php

namespace App\Http\Controllers\API\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Book\BookIssueLogResource;
use App\Models\Book;
use App\Models\BookIssue;
use Illuminate\Http\Request;

class BookIssueLogController extends Controller
{
    public function issue_book_list(Request $request)
    {
        $user = $request->user();

        return BookIssueLogResource::collection($user->books);
        
    }

    public function issue_book(Request $request, Book $book)
    {
        
        $user = $request->user();

        // Check book availability 
        if(!$book->quantity)
        return response()->json(['status' => false, 'message' => 'Book currently not available.']);

        // check if book already issue by user 
        if($user->books()->where('book_id', $book->id)->whereNull('return_at')->count())
        return response()->json(['status' => false, 'message' => 'This book already issue by you.']);

        // log book issued 
        $log = new BookIssue();
        $log->user_id = $user->id;
        $log->book_id = $book->id;
        $log->issued_at = now();
        $log->save();

        // update availability count by minus 1
        $book->decrement('quantity');

        return response()->json(['status' => true, 'message' => 'Book issued successfully.']);

    }


    public function return_book(Request $request, BookIssue $book_issue)
    {

        $user = $request->user();
    
        $book_issue->return_at = now();
        $book_issue->update();

        // update availability count by plus 1
        $book = $book_issue->book;
        $book->increment('quantity');

        return response()->json(['status' => true, 'message' => 'Book return successfully.']);

    }
}
