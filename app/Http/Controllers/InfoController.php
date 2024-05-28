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
            'user_agent' => $request->header('User-Agent')
        ]);
    }

    public function database()
    {
        try {
            $connection = DB::connection();
            $dbInfo = [
                'driver' => $connection->getDriverName(),
                'database' => $connection->getDatabaseName(),
                'host' => $connection->getConfig('host'),
            ];
            return response()->json($dbInfo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not connect to the database'], 500);
        }
    }
}
