<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
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
        'month',
        'amount',
        'status',
        'due_date',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'month' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * A Rent record belongs to a Tenant.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * A Rent record belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A Rent record can have many Payments.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

