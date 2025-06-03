<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';    // biasanya 'id' sudah default
    protected $fillable = ['nama'];  // atribut lain sesuai tabel

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
