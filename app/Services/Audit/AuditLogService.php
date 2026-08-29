<?php

namespace App\Services\Audit;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    public function log(string $event, Model $auditable, array $extra = []): AuditLog
    {
        $user = Auth::user();

        $oldValues = null;
        $newValues = null;

        if ($auditable->exists && $auditable->wasRecentlyCreated === false) {
            if (method_exists($auditable, 'getDirty') && count($auditable->getDirty()) > 0) {
                $oldValues = collect($auditable->getOriginal())
                    ->only(array_keys($auditable->getDirty()))
                    ->toArray();
                $newValues = $auditable->getDirty();
            }
        } elseif ($auditable->wasRecentlyCreated) {
            $newValues = $auditable->toArray();
        }

        if (! empty($extra)) {
            $newValues = $newValues ? array_merge($newValues, $extra) : $extra;
        }

        return AuditLog::create([
            'user_id' => $user?->id,
            'event' => $event,
            'auditable_type' => get_class($auditable),
            'auditable_id' => $auditable->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public function logCustom(string $event, string $auditableType, int|string $auditableId, ?array $oldValues = null, ?array $newValues = null): AuditLog
    {
        $user = Auth::user();

        return AuditLog::create([
            'user_id' => $user?->id,
            'event' => $event,
            'auditable_type' => $auditableType,
            'auditable_id' => $auditableId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => Request::fullUrl(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
