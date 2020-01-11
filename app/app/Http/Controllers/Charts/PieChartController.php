<?php


namespace App\Http\Controllers\Charts;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PieChartController extends Controller
{
    public function index(Request $request)
    {
        $chartData = [
            'labels' => ['March', 'April', 'May', 'June'],
            'datasets' => [
                [
                    'label' => 'Sales',
                    'backgroundColor' => '#32a852',
                    'data' => [1500, 2300, 2000, 4500]
                ]
            ]
        ];
        return response()->json($chartData);
    }

}
