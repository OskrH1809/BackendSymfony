<?php

namespace App\Serializer;

use App\Entity\Comment;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CommentNormalizer implements ContextAwareNormalizerInterface
{

    private  $normalizer;

    public function __construct(
        ObjectNormalizer $normalizer
    ) {
        $this->normalizer = $normalizer;
    }

    public function normalize($comment, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($comment, $format, $context);
        $data['id'] = $comment->getId();
        $data['viewed'] = $comment->getViewed();
        $data['createAt'] = $comment->getCreateAt()->format('d-m-Y H:m:s');
        $data['text'] = $comment->getText();
        $data['idUser'] = $comment->getUser()->getId();
        $data['user'] = $comment->getUser()->getEmail();
        $data['idConversation'] = $comment->getConversation()->getId();
        $data['idtarea'] = $comment->getConversation()->getTarea()->getId();


        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Comment;
    }
}
