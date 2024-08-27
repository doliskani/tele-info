<?php

namespace App\Http\Requests;

use App\Models\Nava;
use App\Rules\MediaUrlValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NavaRequest extends FormRequest
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
        $reg = "^[a-zA-Z0-9]{24}$";
        return [
            "name" => "required|string|max:255",
            "type" => "required|array",
            "type.*" => [Rule::in(Nava::ARRAY_CONTENT_TYPE)],
            "file_urls.*" => ["required", "url", new MediaUrlValidation],
            "content" => "string",

            "channel_id" => "string|max:100",
            "person" => "nullable|string|max:255",
            "image" => "url",

            "person_id" => "string|regex:/$reg/",
            "language_id" => "string|regex:/$reg/",


            "subject_ids" => "array",
            "style_ids" => "array",
            "subject_ids.*" => "string|regex:/$reg/",
            "style_ids.*" => "string|regex:/$reg/",
            "kind_id" => "string|regex:/$reg/",
            "weight_id" => "string|regex:/$reg/",
            "persone_id" => "string|regex:/$reg/",
            "session_id" => "string|regex:/$reg/",
            "content_type_id" => "string|regex:/$reg/",
            "year_id" => "string|regex:/$reg/",
            "occasion_id" => "string|regex:/$reg/",
            "association_id" => "string|regex:/$reg/",
            "poem_format_id" => "string|regex:/$reg/",
            "rhythm_id" => "string|regex:/$reg/",
            "melody_id" => "string|regex:/$reg/",
            "dialect_id" => "string|regex:/$reg/",
            "surah_id" => "string|regex:/$reg/",
            "surah_page_id" => "string|regex:/$reg/",
            "surah_part_id" => "string|regex:/$reg/",
            "hizb_id" => "string|regex:/$reg/",
            "album_id" => "string|regex:/$reg/",
            
        ];
    }
}
