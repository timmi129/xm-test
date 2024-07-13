<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\VO\AbstractString;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use function is_string;

class StringVONormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function denormalize($data, string $type, ?string $format = null, array $context = []): AbstractString
    {
        return $type::create($data);
    }

    public function supportsDenormalization($data, string $type, ?string $format = null): bool
    {
        return is_string($data) && is_a($type, AbstractString::class, true);
    }

    /**
     * @param mixed $object
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return $object->toString();
    }

    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof AbstractString;
    }
}
