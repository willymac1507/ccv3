<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShiftUpdateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'monday.start' => 'Monday start time',
        ];
    }

    public function messages(): array
    {
        return [
            '*.uuid.required' => 'The UUID is required.',
            '*.day.required' => 'The day is required.',
            '*.day.in' => 'The day must be one of the following: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday.',
            '*.dayNumber.required' => 'The day number is required.',
            '*.dayNumber.integer' => 'The day number must be an integer.',
            '*.dayNumber.min' => 'The day number must be at least 1.',
            '*.dayNumber.max' => 'The day number must be at most 7.',
            '*.start.required_with' => 'The start time is required when break is present.',
            '*.end.required_with' => 'The end time is required when start is present.',
            '*.breakDuration.required_with' => 'The break duration is required when break is present.',
            '*.breakDuration.integer' => 'The break duration must be an integer.',
            '*.breakDuration.min' => 'The break duration must be at least 1.',
            '*.breakDuration.max' => 'The break duration must be at most 120.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.uuid' => 'required',
            '*.day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            '*.dayNumber' => 'required|integer|min:1|max:7',
            '*.start' => 'nullable|required_with:*.break',
            '*.end' => 'nullable|required_with:*.start',
            '*.break' => 'nullable',
            '*.breakDuration' => 'nullable|integer|min:1|max:120|required_with:*.break',
        ];
    }
}
