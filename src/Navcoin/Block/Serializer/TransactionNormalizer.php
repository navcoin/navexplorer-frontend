<?php

namespace App\Navcoin\Block\Serializer;

use App\Navcoin\Block\Entity\Transaction;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class TransactionNormalizer
 *
 * @package App\Navcoin\Block\Serializer
 */
class TransactionNormalizer extends ObjectNormalizer
{
    /**
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return array_filter(
            parent::normalize($object, $format, $context),
            function ($value) {
                return null !== $value;
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return \is_object($data) && $data instanceof Transaction;
    }
}
