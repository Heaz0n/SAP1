<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function serverInfo()
    {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_clean();
        return response()->json(['phpinfo' => $phpinfo]);
    }

    public function clientInfo(Request $request)
    {
        return response()->json([
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ]);
    }

    public function databaseInfo()
    {
        $database = DB::connection()->getDatabaseName();
        return response()->json(['database' => $database]);
    }
}