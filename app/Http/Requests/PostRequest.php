<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'image' => 'required|file|image|mimes:png,jpeg',
                'title' => 'required|max:30',
                'description' => 'max:300',
                'tags' => 'max:100|regex:/#+/u'
        ];
    }
}
