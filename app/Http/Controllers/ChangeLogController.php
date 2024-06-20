<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use App\DTOs\ChangeLogCollectionDTO;

class ChangeLogController extends Controller
{
    public function getUserChangeLog($id)
    {
        // Implement logic to fetch user change logs
        $logs = ChangeLog::where('entity_type', 'user')
            ->where('entity_id', $id)
            ->get();

        return new ChangeLogCollectionDTO($logs);
    }

    public function getRoleChangeLog($id)
    {
        // Implement logic to fetch role change logs
        $logs = ChangeLog::where('entity_type', 'role')
            ->where('entity_id', $id)
            ->get();

        return new ChangeLogCollectionDTO($logs);
    }

    public function getPermissionChangeLog($id)
    {
        // Implement logic to fetch permission change logs
        $logs = ChangeLog::where('entity_type', 'permission')
            ->where('entity_id', $id)
            ->get();

        return new ChangeLogCollectionDTO($logs);
    }
}
