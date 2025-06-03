<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'nama', 'harga', 'deskripsi', 'kalori', 'karbohidrat', 'protein', 'sodium', 'gula', 'gambar', 'category_id'
    ];

    public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}

    public function customizations()
    {
        return $this->hasMany(Customization::class, 'menu_id');
    }
}
