<?php

use Illuminate\Support\Facades\Session;

test('language switcher sets session and redirects', function () {
    $this->get('/lang/tr')
        ->assertRedirect();

    expect(Session::get('locale'))->toBe('tr')
        ->and(app()->getLocale())->toBe('tr');

    $this->get('/lang/en')
        ->assertRedirect();

    expect(Session::get('locale'))->toBe('en');
});

test('language switcher ignores invalid locales', function () {
    $currentLocale = app()->getLocale();

    $this->get('/lang/de') // 'de' is not supported
        ->assertRedirect();

    // Session should not change
    expect(Session::get('locale'))->not->toBe('de');
});
