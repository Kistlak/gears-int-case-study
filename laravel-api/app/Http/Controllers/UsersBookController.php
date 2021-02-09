<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersBookController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $books = User::with('book', 'roles', 'status')->where('users.id', '=', $id)->get()->toArray();

//        $find_books_from_authors = DB::table('users')
//            ->join('books', 'users.id', '=', 'books.user_id')
//            ->join('roles', 'users.id', '=', 'roles.user_id')
//            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
//            ->select('users.first_name', 'users.last_name', 'users.slug', 'books.*', 'roles.*', 'status_authors.*')
//            ->where('users.id', '=', $id)
//            ->get()->toArray();

        if(empty($books)) {
            $search_response = 'Nothing Found';
        } else {
            $search_response = $books;
        }

        return [
            'data' => $search_response,
            'response_count' => count($books)
        ];
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
