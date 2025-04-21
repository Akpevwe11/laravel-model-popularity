<?php
use Illuminame\Foundation\Testing\RefreshDatabase;
use App\Models\Series;
use App\Models\Visit;
use Illuminate\Support\Carbon;

it("is true", function () {
   $series = Series::factory()->create();

    $series->visit();

    expect($series->visits->count())->toBe(1);
});

it('it creates visit after a hourly timeframe', function() {
    $series = Series::factory()->create();

    $series->visit()->hourlyIntervals()->withIp();

    Carbon::setTestNow(now()->addHour()->addMinute());

    $series->visit()->hourlyIntervals()->withIp();

    expect($series->visits->count())->toBe(2);
});


it('it creates visits after a daily timeframe', function() {

    $series = Series::factory()->create();

    $series->visit()->dailyInterval()->withIp();

    Carbon::setTestNow(now()->addDay());

    $series->visit()->dailyInterval()->withIp();

    expect($series->visits->count())->toBe(2);

});


it('it creates visits after a weekly timeframe', function() {

    $series = Series::factory()->create();

    $series->visit()->weeklyInterval()->withIp();

    Carbon::setTestNow(now()->addWeek());

    $series->visit()->weeklyInterval()->withIp();

    expect($series->visits->count())->toBe(2);

});

it('it creates visits after a monthly timeframe', function() {

    $series = Series::factory()->create();

    $series->visit()->monthlyInterval()->withIp();

    Carbon::setTestNow(now()->addWeek());

    $series->visit()->weeklyInterval()->withIp();

    expect($series->visits->count())->toBe(2);

});


it('it creates visits after a custom timeframe', function() {

    $series = Series::factory()->create();

    $series->visit()->customInterval(now()->subYear())->withIp();

    Carbon::setTestNow(now()->addYear());

    $series->visit()->customInterval(now()->subYear())->withIp();

});

