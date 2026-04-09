<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'action',
        'entity_type',
        'entity_id',
        'user_email',
        'message',
        'data',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'data' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByEntity($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
