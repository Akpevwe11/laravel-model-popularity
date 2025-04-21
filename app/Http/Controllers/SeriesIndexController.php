<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;

class SeriesIndexController extends Controller
{
    public function __invoke()
    {

        dd(Series::withTotalVisitsCount()->get());
        return view('series.index', [

            'popular' => Series::withTotalVisitsCount()->get()
        ]);
    }
}
