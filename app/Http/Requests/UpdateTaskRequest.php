<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'sometimes|string|max:20' ,
            'discription'=>'sometimes|string|max:150' ,
            'priority'=>'sometimes|integer|min:1|max:5' ,
        ];
    }
    public function messages(){
        return [
            'title.string' => 'يجب أن يكون العنوان نصيًا.',
            'title.max' => 'الحد الأقصى للعنوان هو 20 حرفًا.',

            'discription.string' => 'يجب أن يكون الوصف نصيًا.',
            'discription.max' => 'الحد الأقصى للوصف هو 150 حرفًا.',

            'priority.integer' => 'يجب أن تكون الأولوية رقمًا صحيحًا.',
            'priority.min' => 'أقل قيمة مسموحة للأولوية هي 1.',
            'priority.max' => 'أعلى قيمة مسموحة للأولوية هي 5.',
        ];

    }
}
