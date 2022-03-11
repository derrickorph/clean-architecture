<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'titre',
            'episodes.*.title' => "titre de l'épisode",
            'episodes.*.video_url' => "url de l'épisode",
            'episodes.*.description' => " description de l'épisode",
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $course = Course::find($this->route('id'));

        return $course && $this->user()->can('update', $course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'      =>  'required|string',
            'description'       =>  'required',
            'episodes'       =>  'required|array',
            'episodes.*.title'       =>  'required|string',
            'episodes.*.video_url'       =>  'required|url',
            'episodes.*.description'       =>  'required|max:1000',
        ];
    }
}
