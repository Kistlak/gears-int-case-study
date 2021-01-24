<?php
/**
 * Created by PhpStorm.
 * User: KISTLAK
 * Date: 1/20/2021
 * Time: 12:56 AM
 */

namespace App\Http\Classes;


use Illuminate\Support\Facades\DB;

class UserBooks extends Search
{
    public function searchResults($user_id)
    {
        $find_books_from_authors = DB::table('users')
            ->join('books', 'users.id', '=', 'books.user_id')
            ->join('roles', 'users.id', '=', 'roles.user_id')
            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
            ->select('users.first_name', 'users.last_name', 'users.slug', 'books.*', 'roles.*', 'status_authors.*')
            ->where('users.id', '=', $user_id)
            ->get()->toArray();

        if(empty($find_books_from_authors)) {
            $search_response = 'Nothing Found';
        } else {
            $search_response = $find_books_from_authors;
        }

        return [
            'books_from_authors' => $search_response,
            'response_count' => count($find_books_from_authors)
        ];
    }
}