<?php

namespace App\Serializer;

use App\Entity\Conversation;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ConversationNormalizer implements ContextAwareNormalizerInterface
{

    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }

    public function normalize($conversation, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($conversation, $format, $context);
        $data['id'] = $conversation->getId();
        $data['idTarea'] = $conversation->getTarea()->getId();
        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Conversation;
    }
}
