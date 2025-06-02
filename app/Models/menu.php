<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['nama', 'deskripsi', 'gambar'];
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

}
