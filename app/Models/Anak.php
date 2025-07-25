<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'anak'; 

    protected $fillable = [
    'nama',
    'tanggal_lahir',
    'gender',
    'tinggi_cm',
    'berat_kg',
    'alergi',

];
public function cart()
    {
        return $this->hasMany(Cart::class, 'child_id');
    }
}
