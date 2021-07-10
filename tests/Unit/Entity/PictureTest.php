<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\Picture;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @covers \App\Entity\Picture
 */
final class PictureTest extends TestCase
{
    /**
     * @testdox Sets/gets the picture author's name.
     */
    public function testAuthorName(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setAuthorName('John Doe');

        self::assertEquals('John Doe', $picture->getAuthorName());
    }

    /**
     * @testdox Sets/gets the URL of the picture author's profile.
     */
    public function testAuthorProfile(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setAuthorProfile('https://www.flickr.com/photos/johndoe/');

        self::assertEquals('https://www.flickr.com/photos/johndoe/', $picture->getAuthorProfile());
    }

    /**
     * @testdox Sets/gets the picture height.
     */
    public function testHeight(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setHeight(2000);

        self::assertEquals(2000, $picture->getHeight());
    }

    /**
     * @testdox Sets/gets the picture license.
     */
    public function testLicense(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setLicense('CC-BY-SA-2.0');

        self::assertEquals('CC-BY-SA-2.0', $picture->getLicense());
    }

    /**
     * @testdox Sets/gets the picture source URL.
     */
    public function testSource(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setSource('https://www.flickr.com/photos/johndoe/123456789/');

        self::assertEquals('https://www.flickr.com/photos/johndoe/123456789/', $picture->getSource());
    }

    /**
     * @testdox Sets/gets the local file that will be uploaded upon entity creation or update.
     */
    public function testLocalFile(): void
    {
        $localFile = new File(__FILE__);

        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setLocalFile($localFile);

        self::assertEquals($localFile, $picture->getLocalFile());
    }

    /**
     * @testdox Sets/gets the picture width.
     */
    public function testWidth(): void
    {
        $picture = $this->getMockForAbstractClass(Picture::class);
        $picture->setWidth(3000);

        self::assertEquals(3000, $picture->getWidth());
    }
}
