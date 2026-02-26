<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use softDeletes;

    protected $fillable = [
        'cat_name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }


}
