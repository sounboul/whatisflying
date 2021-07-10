<?php

declare(strict_types=1);

namespace Tests\Unit\Entity;

use App\Entity\FileEntity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @covers \App\Entity\FileEntity
 */
final class FileEntityTest extends TestCase
{
    /**
     * @testdox Sets/gets the file SHA1 checksum.
     */
    public function testChecksum(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setChecksum('45b11c23d365f4bd4c2e2b8a972d8b793e9d3e02');

        self::assertEquals('45b11c23d365f4bd4c2e2b8a972d8b793e9d3e02', $fileEntity->getChecksum());
    }

    /**
     * @testdox Sets/gets the local file that will be uploaded upon entity creation or update.
     */
    public function testLocalFile(): void
    {
        $localFile = new File(__FILE__);

        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setLocalFile($localFile);

        self::assertEquals($localFile, $fileEntity->getLocalFile());
    }

    /**
     * @testdox Sets/gets the file name.
     */
    public function testName(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setName('38fa7d.webp');

        self::assertEquals('38fa7d.webp', $fileEntity->getName());
    }

    /**
     * @testdox Sets/gets the file path.
     */
    public function testPath(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setPath('18bd91ff-c124-4683-934e-a6c82082c2c2.webp');

        self::assertEquals('18bd91ff-c124-4683-934e-a6c82082c2c2.webp', $fileEntity->getPath());
    }

    /**
     * @testdox Sets/gets the file size.
     */
    public function testSize(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setSize(1741589);

        self::assertEquals(1741589, $fileEntity->getSize());
    }

    /**
     * @testdox Sets/gets the file MIME type.
     */
    public function testType(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setType('image/webp');

        self::assertEquals('image/webp', $fileEntity->getType());
    }

    /**
     * @testdox Sets/gets the file absolute URL.
     */
    public function testUrl(): void
    {
        $fileEntity = $this->getMockForAbstractClass(FileEntity::class);
        $fileEntity->setUrl('https://whatisflying.com/upload/16fa1404-fbdc-4316-a465-f124350b834c.webp');

        self::assertEquals(
            'https://whatisflying.com/upload/16fa1404-fbdc-4316-a465-f124350b834c.webp',
            $fileEntity->getUrl()
        );
    }
}
