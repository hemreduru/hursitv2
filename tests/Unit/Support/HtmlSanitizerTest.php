<?php

use App\Support\HtmlSanitizer;

test('html sanitizer strips risky tags and attributes', function () {
    $sanitizer = app(HtmlSanitizer::class);

    $payload = '<p onclick="alert(1)">safe</p>'
        . '<script>window.badToken = "script-token";</script>'
        . '<a href="javascript:alert(\'js-token\')">bad-link</a>'
        . '<iframe src="https://evil.test/frame"></iframe>'
        . '<object data="https://evil.test/object"></object>';

    $sanitized = $sanitizer->sanitizePost($payload);

    expect($sanitized)->toContain('safe')
        ->not->toContain('script-token')
        ->not->toContain('js-token')
        ->not->toContain('onclick')
        ->not->toContain('<script')
        ->not->toContain('<iframe')
        ->not->toContain('<object');
});

test('html sanitizer keeps allowed markup', function () {
    $sanitizer = app(HtmlSanitizer::class);

    $payload = '<p><strong>bold</strong> and <em>italic</em></p>';
    $sanitized = $sanitizer->sanitizeProject($payload);

    expect($sanitized)->toContain('<p>')
        ->toContain('<strong>bold</strong>')
        ->toContain('<em>italic</em>');
});
