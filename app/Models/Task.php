<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;
//use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory, FilterByUser;

    protected $fillable = ['name','project_id'];

    public function project(){

        return $this->belongsTo(Project::class);
    }

    
}
