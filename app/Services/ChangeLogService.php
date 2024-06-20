<?php

namespace App\Services;

use App\Models\ChangeLog;
use App\DTO\ChangeLogDTO;
use Carbon\Carbon;

class ChangeLogService
{
    /**
     * Log a change for a given entity.
     *
     * @param string $entityType
     * @param int $entityId
     * @param array $beforeChange
     * @param array $afterChange
     * @param int $createdBy
     * @return ChangeLogDTO
     */
    public function logChange(string $entityType, int $entityId, array $beforeChange, array $afterChange, int $createdBy): ChangeLogDTO
    {
        $log = ChangeLog::create([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'before_change' => json_encode($beforeChange),
            'after_change' => json_encode($afterChange),
            'created_by' => $createdBy,
            'created_at' => Carbon::now()
        ]);

        return $this->mapToDTO($log);
    }

    /**
     * Map ChangeLog model instance to ChangeLogDTO.
     *
     * @param ChangeLog $log
     * @return ChangeLogDTO
     */
    private function mapToDTO(ChangeLog $log): ChangeLogDTO
    {
        return new ChangeLogDTO(
            $log->id,
            $log->entity_type,
            $log->entity_id,
            json_decode($log->before_change, true),
            json_decode($log->after_change, true),
            $log->created_by,
            $log->created_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * Retrieve change logs for a specific entity.
     *
     * @param string $entityType
     * @param int $entityId
     * @return array
     */
    public function getChangeLogs(string $entityType, int $entityId): array
    {
        $logs = ChangeLog::where('entity_type', $entityType)
                         ->where('entity_id', $entityId)
                         ->orderBy('created_at', 'desc')
                         ->get();

        return $logs->map(function (ChangeLog $log) {
            return $this->mapToDTO($log);
        })->toArray();
    }
}
