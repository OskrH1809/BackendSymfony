<?php

namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UsersNormalizer implements ContextAwareNormalizerInterface
{

    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }

    public function normalize($user, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($user, $format, $context);
        $data['id'] = $user->getId();
        $data['email'] = $user->getEmail();
        $data['role'] = $user->getPerfil()->getNombre();
        $data['data'] = $user->getDataUsers();
        $data['activo'] = $user->getActivo();
        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof User;
    }
}
