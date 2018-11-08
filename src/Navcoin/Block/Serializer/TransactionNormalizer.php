<?php

namespace App\Navcoin\Block\Serializer;

use App\Navcoin\Block\Entity\Transaction;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TransactionNormalizer extends ObjectNormalizer
{
    public function normalize($object, $format = null, array $context = array()): array
    {
        return array_filter(
            parent::normalize($object, $format, $context),
            function ($value) {
                return null !== $value;
            }
        );
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return \is_object($data) && $data instanceof Transaction;
    }
}
