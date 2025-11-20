<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class RouteMessage extends Controller
{
    use HttpResponses;
    public static function success($data, string $message = null, int $code = 200)
    {
        return self::success($data,$message,$code);
    }
    public static function error($data, string $message = null, int $code = 200)
    {
        return self::error($data,$message,$code);
    }

}
