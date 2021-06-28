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
            'title' => 'required|max:30',
            'study_date' => 'required|date_format:Y/m/d',
            'study_hour' => 'nullable|integer|min:0|max:23',
            'study_time' => 'nullable|integer|min:0|max:59',
            'content' => 'required|max:150',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'study_date' => '学習日',
            'content' => '本文',
        ];
    }
}
