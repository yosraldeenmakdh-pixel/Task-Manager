<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use HasFactory;
    protected $fillable=['title','discription','priority','user_id'] ;
    protected $table = 'tasks' ;

    public function user(){
        return $this->belongsTo(User::class) ;
    }
    public function catrgories(){
        return $this->belongsToMany(Category::class,'task_category') ;
    }

    public function favoriteByUser(){
        return $this->belongsToMany(User::class ,'favorites') ;
    }
}
