<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use ApiChef\RequestToEloquent\QueryBuilderAbstract;
use Illuminate\Http\Request;

class BookListQuery extends QueryBuilderAbstract
{
    protected function init(Request $request)
    {
        return User::query();
    }

    protected $availableIncludes = [
        'book',
        'status',
    ];

    protected $availableFilters = [
        'draft',
    ];

    protected $availableSorts = [
        'published_at',
    ];
}
