<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';  // ganti cart jadi cart

    protected $fillable = [
        'child_id',
        'menu_id',
        'quantity',
        'note',
        'options',
        'alamat',
        'jam',
    ];

    protected $casts = [
        'options' => 'array',
        'jam' => 'datetime:H:i',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'child_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
