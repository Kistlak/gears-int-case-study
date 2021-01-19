<?php
/**
 * Created by PhpStorm.
 * User: KISTLAK
 * Date: 1/20/2021
 * Time: 12:55 AM
 */

namespace App\Http\Classes;


use Illuminate\Support\Facades\DB;

class Search
{
    public function search_results($search_keyword)
    {
        $find_books_from_authors = DB::table('users')
            ->join('books', 'users.id', '=', 'books.user_id')
            ->join('roles', 'users.id', '=', 'roles.user_id')
            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
            ->select('users.first_name', 'users.last_name', 'users.slug', 'books.*', 'roles.*', 'status_authors.*')
            ->where('status_authors.status', '=', '1')
            ->where('roles.role', '=', 'author')
            ->where('users.first_name', 'like', '%' . $search_keyword . '%')
            ->orWhere('users.slug', 'like', '%' . $search_keyword . '%')
            ->orWhere('users.last_name', 'like', '%' . $search_keyword . '%')
            ->orWhere('books.book_name', 'like', '%' . $search_keyword . '%')
            ->get();

        $collection = collect($find_books_from_authors);

        $filtered = $collection->filter(function ($value, $key) {
            return $value->status == "1";
        });

        $set_response = $filtered->all();
        if(empty($set_response)) {
            $search_response = 'Nothing Found';
        } else {
            $search_response = $set_response;
        }

        return response()->json([
            'books_from_authors' => $search_response,
            'response_count' => count($set_response)
        ], 200);
    }
}