<?php

use App\Models\Series;
use Carbon\Carbon;

it('gets the total visit count', function() {

    $series = Series::factory()->create();

    $series->visit();

    $series = Series::withTotalVisitsCount()->first();

    expect($series->visit_count_total)->toEqual(1);



});


it('get records by all time popularity', function () {
    Series::factory()->times(2)->create()->each->visit();
    $series = Series::poularAllTime()->get();

    expect($series->count())->toEqual(2);
    expect($series->first()->visit_count_total)->toEqual(1);

});


it('gets popular records between two dates', function () {

    $series = Series::factory()->times(2)->create();

    Carbon::setTestNow(Carbon::createFromDate(1989, 11, 16));

    $series[0]->visit();

    Carbon::setTestNow();

    $series[1]->visit();

    $series = Series::popularBetween(Carbon::createFromDate(1989, 11, 15), Carbon::createFromDate(1989, 11, 17))->get();

    expect($series->count())->toEqual(1);
    expect($series->first()->visit_count)->toEqual(1);

});

it('gets popular records by the last x days', function() {
    $series = Series::factory()->times(2)->create();

    Carbon::setTestNow(now()->addDays(4));

    $series[0]->visit();

    Carbon::setTestNow();

    $series[1]->visit();

    $series = Series::popularLastDays(2)->get();

    expect($series->count())->toEqual(1);
    expect($series->first()->visit_count)->toEqual(1);

});
