<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsActivityLog extends Model
{
    use HasFactory;

    protected $table = 'cms_activity_logs';

    protected $fillable = [
        'log_by',
        'activity_type',
        'dashboard_activity',
        'activity_desc',
        'activity_date',
        'db_table',
        'old_value',
        'new_value',
        'reference',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];
}
