<?php

namespace App\Http\Controllers;

use App\Http\Classes\Search;
use App\Http\Requests\DestroyBookRequest;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public static function index()
    {

        $books = User::with('book', 'roles', 'status')->get();

//        $books = DB::table('books')
//            ->join('users','users.id','books.user_id')
//            ->join('roles','roles.user_id','users.id')
//            ->join('status_authors','status_authors.user_id','roles.user_id')
//            ->select('users.first_name','users.last_name', 'users.slug', 'roles.*', 'books.*', 'status_authors.*')
//            ->where('roles.role', 'author')
//            ->get();

        if(count($books) == 0) {
            $searchResponse = 'Nothing Found';
        } else {
            $searchResponse = $books;
        }

        return response()->json([
            'data' => $searchResponse,
            'response_count' => count($books)
        ], 200);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create([
            'user_id' => Auth::user()->id,
            'book_name' => $request->book_name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response()->json([
            'data' => $book->toArray()
        ], 201);
    }

    public function show($id)
    {
        //
    }

    public function update(StoreBookRequest $request, $id)
    {
        $editBooks = Book::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if($editBooks !== null) {
            $editBooks->book_name = $request->book_name;
            $editBooks->description = $request->description;
            $editBooks->price = $request->price;
            $editBooks->update();

            $message = "Successfully updated";
        } else {
            $message = 'Not editable';
        }

        return response()->json([
            'data' => $message
        ], 200);
    }

    public function destroy(Book $book, DestroyBookRequest $request)
    {
        $book->delete();

        return response()->json([], 204);
    }
}
