<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
     protected $table = 'category';

    // Define the relationship: A Category has many Menus
    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id', 'id'); // 'category_id' is the foreign key in 'menu' table, 'id' is local key in 'category'
    }

    // This method seems like a self-referencing relationship.
    // If not intended for sub-categories, it might be extraneous.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
