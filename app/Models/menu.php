<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    public function menus()
{
    return $this->hasMany(Menu::class);
}

}
