<?php


namespace File\Controllers;


use Common\PageStandardController;
use File\Repository\FileRepository;
use File\UploadedFileManager;

class File extends PageStandardController
{
    public function get(string $path)
    {
        (new UploadedFileManager())->get($path);
    }
}