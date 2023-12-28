<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'website'
    ];

    /**
     * The Room that the room belongs to
     *
     * @return Room
     */
    public function rooms() {
        return $this->hasMany(Room::class);
    }
}
