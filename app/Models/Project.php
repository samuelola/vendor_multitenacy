<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;
// use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use HasFactory, FilterByUser;

    protected $fillable = ['name','user_id'];

    public function task(){
        
        return $this->hasOne(Task::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }
}
