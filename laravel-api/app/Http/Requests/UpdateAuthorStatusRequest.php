<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorStatusRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->hasRole(User::ROLE_ADMIN);
    }

    public function rules()
    {
        return [
            'status' => 'required'
        ];
    }
}
