<?php

namespace App\Services\Photos;


class UploadPhotoRequest
{
    private string $name;
    private string $size;
    private string $type;
    private string $file;

    public function __construct(string $name,string $size, string $type, string $file)
    {
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
        $this->file = $file;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getSize(): string
    {
        return $this->size;
    }


    public function getType(): string
    {
        return $this->type;
    }


    public function getFile(): string
    {
        return $this->file;
    }


}