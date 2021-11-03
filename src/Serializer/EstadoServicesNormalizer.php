<?php

namespace App\Serializer;

use App\Entity\Estado;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EstadoServicesNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;
    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }
    public function normalize($estado, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($estado, $format, $context);
        $data['id'] = $estado->getId();
        $data['estado'] = $estado->getName();
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Estado;
    }
}
