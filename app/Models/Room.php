<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MaintenanceRequest;
use App\Models\RoomType;
use App\Models\Tenant;
use App\Models\Rent;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
        'price',
    ];

    /**
     * A Room belongs to a RoomType.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * A Room can have one Tenant (at a time).
     * This assumes a tenant is directly assigned to a room.
     */
    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }

    /**
     * A Room can have many Rent records.
     */
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    /**
     * A Room can have many MaintenanceRequests.
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}

