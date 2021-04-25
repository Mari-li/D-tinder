<?php


namespace App\Models;


class UserPhoto
{
    private string $name;
    private int $size;
    private string $type;
    private string $file;

    public function __construct(string $name, int $size, string $type, string $file)
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


    public function getSize(): int
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