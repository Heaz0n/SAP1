<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function server()
    {
        return response()->json(['php_version' => phpversion()]);
    }

    public function client(Request $request)
    {
        return response()->json([
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
    }

    public function database()
    {
        $connection = DB::connection();
        return response()->json([
            'database_connection' => $connection->getConfig('driver'),
            'database_name' => $connection->getDatabaseName(),
        ]);
    }
}