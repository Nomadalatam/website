<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidateUpdateProfileRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $currentSalary = removeCommaFromNumbers($this->request->get('current_salary'));
        $expectedSalary = removeCommaFromNumbers($this->request->get('expected_salary'));

        $this->request->set('current_salary', $currentSalary);
        $this->request->set('expected_salary', $expectedSalary);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Auth::user()->id;

        return [
            'candidateSkills'       => 'required',
            'first_name'            => 'required',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:users,email,'.$id,
            'dob'                   => 'nullable|date',
            'phone'                 => 'nullable',
            'marital_status_id'     => 'required',
            'current_salary'        => 'nullable|numeric|min:0|max:999999999',
            'expected_salary'       => 'nullable|numeric|min:0|max:999999999',
            'password'              => 'nullable|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6',
            'candidateLanguage'     => 'required',

        ];
    }
}
