<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'area' => ['required', 'string', 'max:255'],
            'schedule_type' => ['required', 'in:recurring,specific_date'],
            'specific_date' => ['required_if:schedule_type,specific_date', 'nullable', 'date', 'after_or_equal:today'],
            'days' => ['required_if:schedule_type,recurring', 'nullable', 'string', 'max:255'],
            'time_start' => ['required', 'date_format:H:i'],
            'time_end' => ['required', 'date_format:H:i', 'after:time_start'],
            'truck' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,pending,inactive'],
        ];
    }
}
