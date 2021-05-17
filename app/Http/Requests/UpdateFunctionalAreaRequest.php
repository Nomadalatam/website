<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FunctionalArea;

class UpdateFunctionalAreaRequest extends FormRequest
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
        $rules = FunctionalArea::$rules;
        $rules['name'] = 'required|unique:functional_areas,name,'.$this->route('functionalArea')->id;

        return $rules;
    }
}
