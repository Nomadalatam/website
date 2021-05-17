<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\RequiredDegreeLevel;

class UpdateRequiredDegreeLevelRequest extends FormRequest
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
        $rules = RequiredDegreeLevel::$rules;
        $rules['name'] = 'required|unique:required_degree_levels,name,'.$this->route('requiredDegreeLevel')->id;

        return $rules;
    }
}
