<?php

test('en and tr message files have identical key sets', function () {
    $en = require base_path('lang/en/messages.php');
    $tr = require base_path('lang/tr/messages.php');

    expect($en)->toBeArray()
        ->and($tr)->toBeArray();

    $enKeys = array_keys($en);
    $trKeys = array_keys($tr);

    sort($enKeys);
    sort($trKeys);

    expect($trKeys)->toBe($enKeys);
});
