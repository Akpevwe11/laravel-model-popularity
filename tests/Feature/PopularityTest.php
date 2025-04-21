<?php

use App\Models\Series;

it('gets the total visit count', function() {

    $series = Series::factory()->create();

    $series->visit();

    $series = Series::withTotalVisitsCount()->first();

    expect($series->visit_count_total)->toEqual(1);



});
