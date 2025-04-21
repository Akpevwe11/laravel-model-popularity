<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;

class SeriesIndexController extends Controller
{
    public function __invoke()
    {

     
        return view('series.index', [

            'popular' => Series::popularLastDays(2)->get()
        ]);
    }
}
