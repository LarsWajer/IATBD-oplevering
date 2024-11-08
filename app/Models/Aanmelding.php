<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aanmelding extends Model
{
    use HasFactory;

    protected $table = 'aanmeldingen'; // Zorg ervoor dat dit overeenkomt met je migratie

    protected $fillable = ['huisdier_id', 'user_id', 'is_accepted'];

    public function huisdier()
    {
        return $this->belongsTo(Huisdier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

