<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    protected $table = 'customizations';

    protected $fillable = [
        'menu_id', 'opsi_kategori', 'opsi_nama', 'kalori'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}

