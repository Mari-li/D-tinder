<?php

namespace App\Validation;


class ImageValidator
{
    private array $messages = [];

    public function validate(array $request): void
    {
        if (isset($request['fileToUpload'])) {

            $fileinfo = getimagesize($_FILES['fileToUpload']['tmp_name']);
            $width = $fileinfo[0];
            $height = $fileinfo[1];

            $allowedExtensions = ['png', 'jpg', 'jpeg'];

            $fileExtension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

            if (!file_exists($_FILES['fileToUpload']['tmp_name'])) {
                $this->messages[] = 'Choose image file to upload';

            } else if (!in_array($fileExtension, $allowedExtensions)) {
                $this->messages[] = 'Invalid format! Only PNG and JPEG are allowed';

            } else if (($_FILES["fileToUpload"]["size"] > 2000000)) {
                $this->messages[] = 'Image size exceeds 2MB';

            } else if ($width > "500" || $height > "600") {
                $this->messages[] = 'Image dimension should be within 500X600';
            }
        }
    }


    public function getMessages(): array
    {
        return $this->messages;
    }



}