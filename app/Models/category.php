<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
      protected $table = 'category';

    // Tell Laravel that the primary key is not an integer auto-incrementing ID
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Correct menus relationship: foreign key in menu table is 'category_id',
    // and it matches the 'id' (string primary key) in this category table.
    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id', 'id');
    }

    // Keep this if it's for self-referencing categories, otherwise it can be removed
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    

}
