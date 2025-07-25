<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'default_price',
    ];

    /**
     * A RoomType can have many Rooms.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

