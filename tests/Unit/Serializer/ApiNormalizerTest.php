<?php

declare(strict_types=1);

namespace Tests\Unit\Serializer;

use App\Entity\FileEntity;
use App\Serializer\ApiNormalizer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @covers \App\Serializer\ApiNormalizer
 */
final class ApiNormalizerTest extends TestCase
{
    private MockObject|AbstractNormalizer $decorated;

    public function setUp(): void
    {
        $this->decorated = $this
            ->getMockBuilder(AbstractNormalizer::class)
            ->onlyMethods(['setSerializer', 'supportsDenormalization', 'supportsNormalization'])
            ->getMockForAbstractClass();
    }

    /**
     * @testdox Method supportsNormalization() calls decorated normalizer method.
     */
    public function testSupportsNormalization(): void
    {
        $this->decorated
            ->expects(self::once())
            ->method('supportsNormalization')
            ->with(['aircraft_type' => 'A350'], 'json')
            ->will(self::returnValue(true));

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');

        self::assertEquals(true, $apiNormalizer->supportsNormalization(['aircraft_type' => 'A350'], 'json'));
    }

    /**
     * @testdox Method normalize() calls decorated normalizer method.
     */
    public function testNormalize(): void
    {
        $object = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('normalize')
            ->with($object, 'json', ['groups' => ['read']])
            ->will(self::returnValue('{"icaoCode": "B747"}'));

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');

        self::assertEquals('{"icaoCode": "B747"}', $apiNormalizer->normalize($object, 'json', ['groups' => ['read']]));
    }

    /**
     * @testdox Method normalize() sets files absolute URLs.
     */
    public function testNormalizeSetFileAbsoluteUrl(): void
    {
        $object = $this
            ->getMockBuilder(FileEntity::class)
            ->onlyMethods(['getPath', 'setUrl'])
            ->getMock();

        $object
            ->method('getPath')
            ->will(self::returnValue('4368ca18-4c79-408e-9117-0cf6b0ec0d97.webp'));

        $object
            ->expects(self::once())
            ->method('setUrl')
            ->with('https://whatisflying.com/public/4368ca18-4c79-408e-9117-0cf6b0ec0d97.webp');

        $this->decorated
            ->expects(self::once())
            ->method('normalize')
            ->with($object, 'json', ['groups' => ['read']]);

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');
        $apiNormalizer->normalize($object, 'json', ['groups' => ['read']]);
    }

    /**
     * @testdox Method supportsDenormalization() calls decorated normalizer method.
     */
    public function testSupportsDenormalization(): void
    {
        $this->decorated
            ->expects(self::once())
            ->method('supportsDenormalization')
            ->with('{"icaoCode": "ABR"}', 'Airline', 'json')
            ->will(self::returnValue(true));

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');

        self::assertEquals(true, $apiNormalizer->supportsDenormalization('{"icaoCode": "ABR"}', 'Airline', 'json'));
    }

    /**
     * @testdox Method supportsDenormalization() throws when an unsupported decorated normalizer is provided.
     */
    public function testSupportsDenormalizationThrowOnUnsupportedNormalizer(): void
    {
        $decorated = $this
            ->getMockBuilder(NormalizerInterface::class)
            ->getMock();

        self::expectException(\InvalidArgumentException::class);

        $apiNormalizer = new ApiNormalizer($decorated, 'https://whatisflying.com/public');
        $apiNormalizer->supportsDenormalization('{"icaoCode": "LFIT"}', 'Airport', 'json');
    }

    /**
     * @testdox Method denormalize() calls decorated normalizer method.
     */
    public function testDenormalize(): void
    {
        $object = $this
            ->getMockBuilder(\stdClass::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('denormalize')
            ->with('{"icaoCode": "KLAX"}', 'Airport', 'json', ['groups' => ['write']])
            ->will(self::returnValue($object));

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');

        self::assertEquals(
            $object,
            $apiNormalizer->denormalize('{"icaoCode": "KLAX"}', 'Airport', 'json', ['groups' => ['write']])
        );
    }

    /**
     * @testdox Method denormalize() throws when an unsupported decorated normalizer is provided.
     */
    public function testDenormalizeThrowOnUnsupportedNormalizer(): void
    {
        $decorated = $this
            ->getMockBuilder(NormalizerInterface::class)
            ->getMock();

        self::expectException(\InvalidArgumentException::class);

        $apiNormalizer = new ApiNormalizer($decorated, 'https://whatisflying.com/public');
        $apiNormalizer->denormalize('{"icaoCode": "LFPB"}', 'Airport', 'json', ['groups' => ['write']]);
    }

    /**
     * @testdox Method setSerializer() calls decorated normalizer method.
     */
    public function testSetSerializer(): void
    {
        $serializer = $this
            ->getMockBuilder(SerializerInterface::class)
            ->getMock();

        $this->decorated
            ->expects(self::once())
            ->method('setSerializer')
            ->with($serializer);

        $apiNormalizer = new ApiNormalizer($this->decorated, 'https://whatisflying.com/public');
        $apiNormalizer->setSerializer($serializer);
    }
}
