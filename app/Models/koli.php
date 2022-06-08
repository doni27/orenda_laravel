<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class koli extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id', 'name'
     ];
     public function item()
     {
         return $this->hasMany('App\Models\item', 'koli_id');
     }
     public function user()
     {
         return $this->hasOne(User::class,'id','user_id');
     }
}
