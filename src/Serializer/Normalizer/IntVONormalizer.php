<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\VO\AbstractInt;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use function is_int;
use function is_string;

class IntVONormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize($data, string $type, ?string $format = null, array $context = []): AbstractInt
    {
        return $type::create((int) $data);
    }

    public function supportsDenormalization($data, string $type, ?string $format = null): bool
    {
        return (is_int($data) || (is_string($data) && preg_match('/^\+?\d+$/', $data))) && is_a($type, AbstractInt::class, true);
    }

    /**
     * @param mixed $object
     */
    public function normalize($object, ?string $format = null, array $context = []): int
    {
        return $object->toInt();
    }

    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof AbstractInt;
    }
}
