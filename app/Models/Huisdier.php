<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Huisdier extends Model
{
    use HasFactory;

    protected $table = 'aangeboden_huisdieren';

    protected $fillable = ['name', 'ras','geld','informatie', 'user_id', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aanmeldingen()
    {
        return $this->hasMany(Aanmelding::class, 'huisdier_id');
    }
}
