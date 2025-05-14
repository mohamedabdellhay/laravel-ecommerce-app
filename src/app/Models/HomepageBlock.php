<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageBlock extends Model
{
    //
    protected $fillable = ['image_path', 'title', 'description', 'order'];
}
