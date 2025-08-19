<?php

namespace App\Services;

use App\Models\Project;
use App\Exceptions\ProjectNotFoundException;

class ProjectService{


   public function projectById($id){
    $get_project = Project::where('id',$id)->firstOrFail();
    if(!$get_project){
        throw new ProjectNotFoundException('User not found');
    }
    return $get_project;
  }

}




