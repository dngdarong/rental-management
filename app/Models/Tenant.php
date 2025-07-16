<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'gender',
        'room_id',
        'start_date',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    /**
     * A Tenant belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A Tenant can have many Rent records.
     */
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }

    /**
     * A Tenant can have many Payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * A Tenant can have many MaintenanceRequests.
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}

