<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    /**
     * @var array<string, HTMLPurifier>
     */
    protected array $purifiers = [];

    public function sanitizePost(?string $html): string
    {
        return $this->sanitize($html, 'post');
    }

    public function sanitizeProject(?string $html): string
    {
        return $this->sanitize($html, 'project');
    }

    public function sanitize(?string $html, string $profile = 'default'): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        return $this->getPurifier($profile)->purify($html);
    }

    protected function getPurifier(string $profile): HTMLPurifier
    {
        if (! isset($this->purifiers[$profile])) {
            $this->purifiers[$profile] = new HTMLPurifier($this->buildConfig($profile));
        }

        return $this->purifiers[$profile];
    }

    protected function buildConfig(string $profile): HTMLPurifier_Config
    {
        $cachePath = storage_path('framework/cache/htmlpurifier');

        if (! is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cachePath);
        $config->set(
            'HTML.Allowed',
            'p,br,ul,ol,li,strong,b,em,i,u,s,blockquote,pre,code,h1,h2,h3,h4,h5,h6,a[href|title|target|rel],span'
        );
        $config->set('HTML.ForbiddenElements', [
            'script',
            'style',
            'iframe',
            'object',
            'embed',
            'form',
            'input',
            'button',
            'textarea',
            'link',
            'meta',
            'base',
        ]);
        $config->set('CSS.AllowedProperties', []);
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
        ]);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.Nofollow', true);

        // Profile hook for future content-specific policies.
        if ($profile === 'post' || $profile === 'project') {
            return $config;
        }

        return $config;
    }
}
