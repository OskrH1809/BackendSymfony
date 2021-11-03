<?php

namespace App\Serializer;

use App\Entity\DataUser;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DataUserNormalizer implements ContextAwareNormalizerInterface
{

    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }

    public function normalize($dataUser, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($dataUser, $format, $context);
        $data['id'] = $dataUser->getId();
        $data['user'] = $dataUser->getUser()->getUsername();
        $data['cuentaBanco'] = $dataUser->getCuentaBanco();
        $data['telefono'] = $dataUser->getTelefono();
        $data['direccion'] = $dataUser->getDireccion();
        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof DataUser;
    }
}
