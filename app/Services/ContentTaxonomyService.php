<?php

namespace App\Services;

use App\Exceptions\InvalidTaxonomySelectionException;

class ContentTaxonomyService
{
    public function categories(): array
    {
        return array_values(config('content_taxonomy.categories', []));
    }

    public function optionalTags(): array
    {
        return array_values(config('content_taxonomy.optional_tags', []));
    }

    public function categorySlugs(): array
    {
        return array_values(array_map(
            static fn (array $category): string => (string) $category['slug'],
            $this->categories()
        ));
    }

    public function optionalTagSlugs(): array
    {
        return array_values(array_map(
            static fn (array $tag): string => (string) $tag['slug'],
            $this->optionalTags()
        ));
    }

    /**
     * @return array<int, array{slug: string, name_en: string, name_tr: string}>
     */
    public function resolveCanonicalSelection(string $primarySlug, array $secondarySlugs): array
    {
        $maxSecondary = (int) config('content_taxonomy.limits.secondary_tags_max', 2);
        $secondarySlugs = array_values(array_unique(array_map('strval', $secondarySlugs)));

        if (count($secondarySlugs) > $maxSecondary) {
            throw new InvalidTaxonomySelectionException('Too many secondary tags selected.');
        }

        $resolved = [];
        $category = $this->findBySlug($primarySlug, $this->categories());

        if (! $category) {
            throw new InvalidTaxonomySelectionException('Invalid primary category slug.');
        }

        $resolved[] = $category;

        foreach ($secondarySlugs as $secondarySlug) {
            $optionalTag = $this->findBySlug($secondarySlug, $this->optionalTags());

            if (! $optionalTag) {
                throw new InvalidTaxonomySelectionException('Invalid secondary tag slug.');
            }

            $resolved[] = $optionalTag;
        }

        return $resolved;
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array{slug: string, name_en: string, name_tr: string}|null
     */
    protected function findBySlug(string $slug, array $items): ?array
    {
        foreach ($items as $item) {
            if (($item['slug'] ?? null) === $slug) {
                return [
                    'slug' => (string) $item['slug'],
                    'name_en' => (string) $item['name_en'],
                    'name_tr' => (string) $item['name_tr'],
                ];
            }
        }

        return null;
    }
}
