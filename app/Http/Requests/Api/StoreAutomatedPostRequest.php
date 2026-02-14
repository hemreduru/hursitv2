<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreAutomatedPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    protected function prepareForValidation(): void
    {
        $secondaryTagSlugs = $this->secondary_tag_slugs;

        if (! is_array($secondaryTagSlugs)) {
            $secondaryTagSlugs = [];
        }

        $normalizedSecondaryTags = array_values(array_unique(array_filter(array_map(
            static fn ($value): string => Str::lower(trim((string) $value)),
            $secondaryTagSlugs
        ))));

        $this->merge([
            'slug_en' => $this->slug_en ?: Str::slug((string) $this->title_en),
            'slug_tr' => $this->slug_tr ?: Str::slug((string) $this->title_tr),
            'status' => $this->status ?? 'published',
            'secondary_tag_slugs' => $normalizedSecondaryTags,
            'primary_category_slug' => Str::lower(trim((string) $this->primary_category_slug)),
        ]);
    }

    public function rules(): array
    {
        $categorySlugs = array_values(array_map(
            static fn (array $item): string => (string) $item['slug'],
            config('content_taxonomy.categories', [])
        ));

        $optionalTagSlugs = array_values(array_map(
            static fn (array $item): string => (string) $item['slug'],
            config('content_taxonomy.optional_tags', [])
        ));

        return [
            'title_en' => ['required', 'string', 'max:255'],
            'title_tr' => ['required', 'string', 'max:255'],
            'short_description_en' => ['required', 'string'],
            'short_description_tr' => ['required', 'string'],
            'content_en' => ['required', 'string'],
            'content_tr' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'slug_en' => ['required', 'string', 'max:255', 'unique:posts,slug_en'],
            'slug_tr' => ['required', 'string', 'max:255', 'unique:posts,slug_tr'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'source_url' => ['required', 'url', 'max:2048'],
            'primary_category_slug' => ['required', Rule::in($categorySlugs)],
            'secondary_tag_slugs' => ['nullable', 'array', 'max:'.(int) config('content_taxonomy.limits.secondary_tags_max', 2)],
            'secondary_tag_slugs.*' => ['string', 'distinct', Rule::in($optionalTagSlugs)],
        ];
    }
}
