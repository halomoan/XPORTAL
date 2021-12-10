<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

     // Added by Halomoan
    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id'
    ];

     protected $fillable = [
        'billaddr'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
