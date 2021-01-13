<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\Book;
use App\Models\Role;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Collection\Collection;

class AuthorController extends Controller
{
    public function register_user(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => Str::slug($request->first_name.' '.$request->last_name, '-'),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $role = new Role;
        $role->role = "author";
        $user->role()->save($role);

        $status = new StatusAuthor();
        $status->status = "active";
        $user->status()->save($status);

        return response()->json([
            'response' => $user,
            'response_code' => 1
        ], 200);
    }

    public function add_books(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'response' => 'User not found',
                'response_code' => 0
            ], 403);
        }

        if(Auth::user()->id == $request->user_id) {
            $save_books = Book::create([
                'user_id' => $request->user_id,
                'book_name' => $request->book_name,
                'description' => $request->description,
                'price' => $request->price
            ]);

            $message = "Successfully added";
            $response_code = 1;
        } else {
            $message = "You have no permission to do this";
            $response_code = 0;
        }

        return response()->json([
            'message' => $message,
            'response_code' => $response_code
        ], 200);
    }

    public function edit_books(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'book_name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'response' => 'User not found',
                'response_code' => 0
            ], 403);
        }

        if(Auth::user()->id == $request->user_id) {
            try {
                $find_book = Book::findOrFail($request->book_id);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'response' => 'Book not found',
                    'response_code' => 0
                ], 403);
            }

            $edit_book = Book::where('user_id', $request->user_id)->where('id', $request->book_id)->first();
            if($edit_book !== null) {
                $edit_book->book_name = $request->book_name;
                $edit_book->description = $request->description;
                $edit_book->price = $request->price;
                $edit_book->update();

                $message = "Successfully deleted";
                $response_code = 1;
            } else {
                $message = 'You cant edit other authors books';
                $response_code = 0;
            }
        } else {
            $message = "You have no permission to do this";
            $response_code = 0;
        }

        return response()->json([
            'response' => $message,
            'response_code' => $response_code
        ], 200);
    }

    public function delete_books(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'response' => 'User not found',
                'response_code' => 0
            ], 403);
        }

        if(Auth::user()->id == $request->user_id) {
            try {
                $find_book = Book::findOrFail($request->book_id);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'response' => 'Book not found',
                    'response_code' => 0
                ], 403);
            }

            $delete_book = Book::where('user_id', $request->user_id)->where('id', $request->book_id)->first();
            if($delete_book !== null) {
                $delete_book->delete();

                $message = $delete_book;
                $response_code = 1;
            } else {
                $message = 'You cant delete other authors books';
                $response_code = 0;
            }
        } else {
            $message = "You have no permission to do this";
            $response_code = 0;
        }

        return response()->json([
            'response' => $message,
            'response_code' => $response_code
        ], 200);
    }

    public function search_results(Request $request)
    {
        $request->validate([
            'search_book' => 'required'
        ]);

        $search_keyword = $request->search_book;

        $find_books_from_authors = DB::table('users')
            ->join('books', 'users.id', '=', 'books.user_id')
            ->join('roles', 'users.id', '=', 'roles.user_id')
            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
            ->select('users.first_name', 'users.last_name', 'users.slug', 'books.*', 'roles.*', 'status_authors.*')
            ->where('status_authors.status', '=', 'active')
            ->where('roles.role', '=', 'author')
            ->where('users.first_name', 'like', '%' . $search_keyword . '%')
            ->orWhere('users.slug', 'like', '%' . $search_keyword . '%')
            ->orWhere('users.last_name', 'like', '%' . $search_keyword . '%')
            ->orWhere('books.book_name', 'like', '%' . $search_keyword . '%')
            ->get();

        $collection = collect($find_books_from_authors);

        $filtered = $collection->filter(function ($value, $key) {
            return $value->status == "active";
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

    public function user(Request $request)
    {
        return $request->user();
    }

    public function all_books()
    {
        $all_books = DB::table('books')
            ->join('users','users.id','books.user_id')
            ->join('roles','roles.user_id','users.id')
            ->join('status_authors','status_authors.user_id','roles.user_id')
            ->select('users.first_name','users.last_name', 'users.slug', 'roles.*', 'books.*', 'status_authors.*')
            ->where('roles.role', 'author')
            ->get();

        if(count($all_books) == 0) {
            $search_response = 'Nothing Found';
        } else {
            $search_response = $all_books;
        }

        return response()->json([
            'books_from_authors' => $search_response,
            'response_count' => count($all_books)
        ], 200);
    }

    public function all_users()
    {
        $all_users = DB::table('users')
            ->join('roles', 'users.id', '=', 'roles.user_id')
            ->join('status_authors', 'users.id', '=', 'status_authors.user_id')
            ->select('users.*', 'roles.*', 'status_authors.*')
            ->get();

        return response()->json([
            'all_users' => $all_users,
            'response_count' => count($all_users)
        ], 200);
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'status' => 'required'
        ]);

        try {
            $user = User::findOrFail($request->user_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'response' => 'User not found',
                'response_code' => 0
            ], 403);
        }

        $get_status = $user->status()->first();

        if($get_status->status == $request->status) {
            $message = "Already this author is $get_status->status";
            $response_code = 0;
        } else {
            $edit_status = StatusAuthor::where('id', $get_status->id)->first();
//            $edit_status = DB::table('status_authors')->where('id', $get_status->id)->first();
            $edit_status->status = $request->status;
            $edit_status->update();

            $message = $edit_status;
            $response_code = 1;
        }

        return response()->json([
            'response' => $message,
            'response_code' => $response_code
        ], 200);
    }
}
