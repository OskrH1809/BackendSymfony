<?php

namespace App\Serializer;

use App\Entity\Perfil;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PerfilNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }
    public function normalize($perfil, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($perfil, $format, $context);
        $data['id'] = $perfil->getId();
        $data['nombre'] = $perfil->getNombre();
        $data['acceso'] = $perfil->getAcceso();
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Perfil;
    }
}
