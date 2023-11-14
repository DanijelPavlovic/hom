<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;



class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function amountSpent(Request $request)
    {
        $month = $request->query('month') ? $request->query('month') : Carbon::now()->month;
        $year = $request->query('year') ? $request->query('year') : Carbon::now()->year;

        $query = Expense::where('user_id', Auth::user()->id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        return $this->successfullResponse([
            'data' => $query->sum('amount'),
        ]);
    }
}
