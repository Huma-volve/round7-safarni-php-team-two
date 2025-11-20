<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public static function getDiff($start,$end)
    {
        $start=Carbon::parse($start);
        $end=Carbon::parse($end);
        $diff=$end->diffInMinutes($start);
        $TotalHours=abs(floor($diff/60));
        $RemainingMin=abs(floor($diff%60));
        return $TotalHours . 'h ' . $RemainingMin . 'm';
    }
}
