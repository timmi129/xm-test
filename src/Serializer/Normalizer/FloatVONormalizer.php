<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\VO\AbstractFloat;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use function is_float;

class FloatVONormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize($data, string $type, ?string $format = null, array $context = []): AbstractFloat
    {
        return $type::create($data);
    }

    public function supportsDenormalization($data, string $type, ?string $format = null): bool
    {
        return is_float($data) && is_a($type, AbstractFloat::class, true);
    }

    /**
     * @param mixed $object
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return $object->getValue();
    }

    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof AbstractFloat;
    }
}
