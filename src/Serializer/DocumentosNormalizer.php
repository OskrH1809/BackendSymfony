<?php

namespace App\Serializer;

use App\Entity\Documentos;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DocumentosNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;
    private $urlHelper;
    public function __construct(
        ObjectNormalizer $normalizer,
        UrlHelper $urlHelper
    ) {
        $this->normalizer = $normalizer;
        $this->urlHelper = $urlHelper;
    }
    public function normalize($documentos, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($documentos, $format, $context);
        $data['id'] = $documentos->getId();
        $data['tipoDocumento'] = $documentos->getTipo()->getNombre();
        $data['user'] = $documentos->getUser()->getEmail();
        $data['idUser'] = $documentos->getUser()->getId();
        $data['creado'] = $documentos->getCreateAt();
        $data['mesCreado'] = $documentos->getCreateAt()->format('n');
        $data['editado'] = $documentos->getUpdateAt();
        $data['depende'] = $documentos->getDependent();
        if(!empty($documentos->getNombre())){
        $data['archivo'] = $this->urlHelper->getAbsoluteUrl('/'.$documentos->getRuta().$documentos->getNombre());
        // $data['archivo'] = 'http://127.0.0.1:8000/'.$documentos->getRuta().$documentos->getNombre();
    }
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Documentos;
    }
}
