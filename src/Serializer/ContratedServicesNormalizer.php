<?php

namespace App\Serializer;

use App\Entity\ServiciosContratados;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ContratedServicesNormalizer implements ContextAwareNormalizerInterface
{

    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }

    public function normalize($contratedServices, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($contratedServices, $format, $context);
        $data['id'] = $contratedServices->getId();
        $data['usuario'] = $contratedServices->getUser()->getEmail();
        $data['servicio'] = $contratedServices->getServicio()->getName();
        $data['precio'] = $contratedServices->getServicio()->getPrice();
        $data['idServicio'] = $contratedServices->getServicio()->getId();
        $data['idUsuario'] = $contratedServices->getUser()->getId();
        $data['activo'] = $contratedServices->getActivo();
        $data['servicioActivo'] = $contratedServices->getServicio()->getActivo();
        $data['hours_service'] = $contratedServices->getServicio()->getHoursService();
        $data['periodo_pago'] = $contratedServices->getPeriodoPago();


        
        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof ServiciosContratados;
    }
}
