<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function serverInfo()
    {
        return response()->json([
            'php_version' => phpversion()
        ]);
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
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'sqlite') {
            $database = config("database.connections.{$connection}.database");
        } else {
            $database = DB::connection()->getDatabaseName();
        }

        return response()->json([
            'driver' => $driver,
            'database' => $database
        ]);
    }
}
