<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';
    public function category()
{
    return $this->belongsTo(Category::class);
}

}
