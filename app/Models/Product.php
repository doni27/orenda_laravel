<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    // protected $fillable = [
    //    'name', 'qty', 'stock'
    // ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $dates = ['deleted_at'];
}
