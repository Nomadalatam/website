<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CareerLevel;

class UpdateCareerLevelRequest extends FormRequest
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
        $rules = CareerLevel::$rules;
        $rules['level_name'] = 'required|unique:career_levels,level_name,'.$this->route('careerLevel')->id;

        return $rules;
    }
}
