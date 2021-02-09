<?php

namespace App\Http\Controllers;

use App\Http\Classes\Search;
use Illuminate\Http\Request;

class SearchResultController extends Controller
{
    public function index()
    {
        if(!request()->query('searchKeyword')) {
            return response()->json([
                'data' => "Enter search keyword"
            ], 404);
        }

        $searchKeyword = request()->query('searchKeyword');
        $search = new Search();
        return $search->searchResults($searchKeyword);
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
        //
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
