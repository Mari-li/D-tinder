<?php

declare(strict_types=1);

namespace Test;

use App\Models\UserPhoto;
use PHPUnit\Framework\TestCase;

class UserPhotoTest extends TestCase
{

    public function testName(): void
    {
        $photo = new UserPhoto('myimage.png', '1035kb', 'png', 'storage/files/images/apdlfkgkerfsdv.png');
        $this->assertEquals('myimage.png', $photo->getName() );

    }


}