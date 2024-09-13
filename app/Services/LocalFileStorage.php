<?php

namespace App\Services;

use App\Interface\FileStorage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class LocalFileStorage implements FileStorage{

     public function localFileStoreFile($directory,$image,$path){
          $location=public_path($directory.$path);
          Image::read($image)->resize(800, 900)->save($location);
          return  $directory.$path;
     }

     public function s3FileStoreFile($directory,$image,$path){
          Storage::disk('s3')->put($directory.$path, $image->stream(), 'public');
          $awsPath = Storage::disk('s3')->url($path);
          return $awsPath;
     }

     
}