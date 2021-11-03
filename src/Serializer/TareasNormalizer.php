<?php

namespace App\Serializer;
use App\Entity\Tareas;
use App\Repository\TareasRepository;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TareasNormalizer implements ContextAwareNormalizerInterface
{
    private  $normalizer;
    private TareasRepository $tareasRepository;
    public function __construct(
        ObjectNormalizer $normalizer,
        TareasRepository $tareasRepository
    ) {
        $this->normalizer = $normalizer;
        $this->tareasRepository=$tareasRepository;
    }
    public function normalize($tareas, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($tareas, $format, $context);

        $data['id'] = $tareas->getId();
        $data['titulo'] = $tareas->getTitulo();
        $data['descripcion'] = $tareas->getDescripcion();
        $data['idServicio'] = $tareas->getServicio()->getId();
        $data['servicio'] = $tareas->getServicio()->getName();
        $data['tiempo_restante_servicio'] = $tareas->getServicio()->getTimeRemaining();
        $data['idUsuario'] = $tareas->getUser()->getId();
        $data['usuario'] = $tareas->getUser()->getEmail();
        $data['estado'] = $tareas->getEstado()->getName();
        $data['idEstado'] = $tareas->getEstado()->getId();
        $data['tiempo'] = $tareas->getTiempoTarea();
        $data['user'] = $tareas->getUser()->getEmail();
        $data['mensajesNuevoAdmin'] = (int)$this->tareasRepository->contadorMensajesAdmin($data['id'])['nuevos_mensajes_admin']; 
        $data['mensajesNuevosUser'] = (int) $this->tareasRepository->contadorMensajesUser($data['id'])['nuevos_mensajes_user']; 
        return $data;
    }
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Tareas;
    }
}
