<?php

namespace App\Interface;

interface FileStorage
{
    public function localFileStoreFile($directory,$file,$path);
    public function s3FileStoreFile($directory,$file,$path);
}
