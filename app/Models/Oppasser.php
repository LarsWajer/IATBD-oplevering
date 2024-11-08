<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oppasser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'photo', 'review'];
    
    protected $casts = [
        'reviews' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aanmeldingen()
    {
        return $this->hasMany(Aanmelding::class, 'user_id'); // Zorg dat 'user_id' de juiste foreign key is
    }

}
