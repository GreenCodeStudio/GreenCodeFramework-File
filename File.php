<?php


namespace File;


use File\Repository\FileRepository;

class File
{

    public function upload($file)
    {
        $id = hash('sha1', uniqid(true));//sha to prevent guessing
        $fileSize = filesize($file['tmp_name']);
        move_uploaded_file($file['tmp_name'], $this->getDir().'/'.$id.'.bin');
        $lastDotPos = strrpos($file['name'], '.');
        if ($lastDotPos >= 0) {
            $name = substr($file['name'], 0, $lastDotPos);
            $extension = substr($file['name'], $lastDotPos + 1);
        } else {
            $name = $file['name'];
            $extension = null;
        }
        $data = ['id' => $id, 'name' => $name, 'extension' => $extension, 'mime' => $this->getMimeByExtension($extension) ?? $file['type'], 'size' => $fileSize];
        $this->fillBySpecificInfo($data);
        (new FileRepository())->insert($data);
        return $data;
    }

    public function getDir()
    {
        $dir = __DIR__.'/../../'.($_ENV['UploadedFiles'] ?? 'UploadedFiles');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

    private function getMimeByExtension($extension)
    {
        $mimes = ['png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg'];
        return $mimes[$extension] ?? null;
    }

    private function fillBySpecificInfo(&$data)
    {
        $path = $this->getDir().'/'.$data['id'].'.bin';
        if ($data['mime'] == 'image/png' || $data['mime'] == 'image/jpeg') {
            $size = getimagesize($path);
            $data['image_width'] = $size[0];
            $data['image_height'] = $size[1];
            $data['mime'] = $size['mime'];
        }
    }
}