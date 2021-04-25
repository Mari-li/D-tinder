<?php


class Messages
{
    private array $messages = [];

    public function registrationMessage(): string
    {
        return "You are successfully registered on Tinder!";
    }

    public function fileUploadMessage(): string
    {
        return 'File is uploaded';
    }

}