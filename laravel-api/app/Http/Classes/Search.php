<?php
/**
 * Created by PhpStorm.
 * User: KISTLAK
 * Date: 1/20/2021
 * Time: 12:55 AM
 */

namespace App\Http\Classes;

use App\Models\Book;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Search
{
    public function searchResults($search_keyword)
    {

//        $books = Book::with('authors')->get()->toArray();
//        $books = User::with('book', 'status')->get()->toArray();
//        $books = StatusAuthor::with('authorStatus.book')->active()
//            ->get()->toArray();

        $books = StatusAuthor::with("authorStatus.book")
            ->whereHas('authorStatus.book',function($query) use ($search_keyword){
                $query->where("first_name","like","%{$search_keyword}%")
                    ->orWhere('slug', 'like', '%' . $search_keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $search_keyword . '%')
                    ->orWhere("book_name","like","%{$search_keyword}%");
            })
            ->where("status",'1')->get()->toArray();

//        $find_books_from_authors = DB::table('users')
//            ->join('books', 'users.id', '=', 'books.user_id')
//            ->join('roles', 'users.id', '=', 'roles.user_id')
//            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
//            ->select('users.first_name', 'users.last_name', 'users.slug', 'books.*', 'roles.*', 'status_authors.*')
//            ->where('status_authors.status', '=', '1')
//            ->where('roles.role', '=', 'author')
//            ->where('users.first_name', 'like', '%' . $search_keyword . '%')
//            ->orWhere('users.slug', 'like', '%' . $search_keyword . '%')
//            ->orWhere('users.last_name', 'like', '%' . $search_keyword . '%')
//            ->orWhere('books.book_name', 'like', '%' . $search_keyword . '%')
//            ->get();
//
//        $collection = collect($find_books_from_authors);
//
//        $filtered = $collection->filter(function ($value, $key) {
//            return $value->status == "1";
//        });

//        $set_response = $filtered->all();
        $set_response = $books;
        if(empty($set_response)) {
            $search_response = 'Nothing Found';
        } else {
            $search_response = $set_response;
        }

        return response()->json([
            'data' => $search_response,
            'response_count' => count($set_response)
        ], 200);
    }
}