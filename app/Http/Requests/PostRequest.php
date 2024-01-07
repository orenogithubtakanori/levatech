<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'post.title' => 'required|string|max:100',
            //'post.title'がhtmlのname属性（キー）、右辺がルール（required=入力されていること、string=文字列であること、max:100=最大100文字）
            'post.body' => 'required|string|max:4000',
        ];
    }
}
