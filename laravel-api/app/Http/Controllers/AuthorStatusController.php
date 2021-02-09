<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAuthorStatusRequest;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorStatusController extends Controller
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
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdateAuthorStatusRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $status = $user->status()->first();

        if($status->status == $request->status) {
            $message = "Already this author is $status->status";
        } else {
            $status = StatusAuthor::where('id', $status->id)->first();
            $status->status = $request->status;
            $status->update();

            $message = $status;
        }

        return response()->json([
            'data' => $message
        ], 200);
    }

    public function destroy($id)
    {
        //
    }
}
