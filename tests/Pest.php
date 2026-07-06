<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific
| PHPUnit test case class. By default, that class is "PHPUnit\Framework\TestCase".
| Of course, you may need to change it using the "uses()" function.
|
*/

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain
| conditions. The "expect()" function gives you access to a set of "expectations"
| methods that you can use to assert different things.
|
*/

expect()->extend('toBeCloseTo', function (float $expected, float $tolerance = 1e-4) {
    return $this->toBeGreaterThanOrEqual($expected - $tolerance)
        ->toBeLessThanOrEqual($expected + $tolerance);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Helper functions yang dapat dipakai di seluruh test suite.
|
*/

/**
 * Bobot WP default sesuai RULES.md §3.4 — (5, 4, 4, 2, 2)
 *
 * @return array<int, array{bobot_mentah: int, tipe: string}>
 */
function bobotDefault(): array
{
    return [
        ['bobot_mentah' => 5, 'tipe' => 'benefit'],  // C1 Laba Usaha
        ['bobot_mentah' => 4, 'tipe' => 'benefit'],  // C2 Pendapatan Bersih
        ['bobot_mentah' => 4, 'tipe' => 'benefit'],  // C3 Nilai Agunan
        ['bobot_mentah' => 2, 'tipe' => 'cost'],     // C4 Besar Pembiayaan
        ['bobot_mentah' => 2, 'tipe' => 'cost'],     // C5 Jangka Waktu
    ];
}
