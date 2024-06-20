<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class ChangeLogCollectionDTO
{
    public $logs;

    public function __construct(Collection $logs)
    {
        $this->logs = $logs->map(function ($log) {
            return new ChangeLogDTO([
                'entityType' => $log->entity_type,
                'entityId' => $log->entity_id,
                'beforeChange' => $log->before_change,
                'afterChange' => $log->after_change,
            ]);
        });
    }
}
