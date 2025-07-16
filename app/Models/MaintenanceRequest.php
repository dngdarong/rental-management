<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'room_id',
        'title',
        'description',
        'status',
        'reported_at',
        'completed_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reported_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * A MaintenanceRequest may belong to a Tenant (nullable).
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * A MaintenanceRequest belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

