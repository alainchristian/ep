<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $studentId = $this->route('student.StudentID');

        return [
            'UniqueID' => [
                'required',
                'string',
                'max:20',
                'unique:student,UniqueID,' . $studentId . ',StudentID'
            ],
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'FamilyID' => 'required|exists:family,FamilyID',
            'Gender' => 'required|in:Male,Female',
            'IsActive' => 'boolean'
        ];
    }
}
