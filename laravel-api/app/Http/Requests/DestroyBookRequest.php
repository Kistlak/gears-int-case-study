<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class DestroyBookRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('delete', $this->route('book'));
//        return $this->route('book')->user_id == $this->user()->id || $this->user()->hasRole(User::ROLE_ADMIN);
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
