<?php

namespace App\Serializer;

use App\Entity\Services;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ServicesNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }
    public function normalize($service, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($service, $format, $context);
        if (!empty($service->getDate())) {
            $data['date'] = $service->getDate()->format('d-m-Y H:m:s');
        }
        $data['activo'] = $service->getActivo();
        $data['hours_service'] = $service->getHoursService();
        $data['time_remaining'] = $service->getTimeRemaining();
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Services;
    }
}
