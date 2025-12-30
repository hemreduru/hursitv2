<?php

uses(Tests\TestCase::class)->in('Feature', 'Unit');
uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class)->in('Feature', 'Unit');


/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code that is specific
| to your project. By adding functions to this file, you can ensure that you have standard
| formatting across your project.
|
*/
