<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function getServerInfo()
    {
        ob_start();
        phpinfo(INFO_GENERAL);
        $phpinfo = ob_get_clean();

        return response()->json(['php_info' => $phpinfo]);
    }

    public function getClientInfo(Request $request)
    {
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');

        return response()->json(['ip' => $ip, 'user_agent' => $userAgent]);
    }

    public function getDatabaseInfo()
    {
        $databaseName = DB::connection()->getDatabaseName();

        return response()->json(['database_name' => $databaseName]);
    }
}