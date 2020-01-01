<?php


namespace App\Http\Controllers\Charts;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LineChartController extends Controller
{
    public function index(Request $request)
    {
        return view('charts/liner');
    }

}
