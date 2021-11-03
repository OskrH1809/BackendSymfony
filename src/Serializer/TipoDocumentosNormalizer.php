<?php

namespace App\Serializer;

use App\Entity\TipoDocumentos;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TipoDocumentosNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }
    public function normalize($tipoDocumentos, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($tipoDocumentos, $format, $context);
        $data['id'] = $tipoDocumentos->getId();
        $data['tipoDocumentos'] = $tipoDocumentos->getNombre();
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof TipoDocumentos;
    }
}
