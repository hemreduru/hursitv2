<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug_en' => $this->slug_en ?: Str::slug($this->title_en),
            'slug_tr' => $this->slug_tr ?: Str::slug($this->title_tr),
            'status' => $this->status ?? 'draft',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title_en' => 'required|string|max:255',
            'title_tr' => 'required|string|max:255',
            'short_description_en' => 'required|string',
            'short_description_tr' => 'required|string',
            'content_en' => 'required|string',
            'content_tr' => 'required|string',
            'status' => 'nullable|in:draft,published',
            'slug_en' => 'required|string|max:255|unique:posts,slug_en',
            'slug_tr' => 'required|string|max:255|unique:posts,slug_tr',
            'thumbnail' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string',
        ];
    }
}
