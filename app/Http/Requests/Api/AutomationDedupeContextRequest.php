<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AutomationDedupeContextRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'days' => $this->days ?? (int) config('content_taxonomy.dedupe.days_default', 180),
            'limit' => $this->limit ?? (int) config('content_taxonomy.dedupe.limit_default', 100),
        ]);
    }

    public function rules(): array
    {
        return [
            'days' => ['required', 'integer', 'min:1', 'max:365'],
            'limit' => ['required', 'integer', 'min:1', 'max:200'],
        ];
    }
}
