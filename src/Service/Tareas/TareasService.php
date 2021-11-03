<?php


namespace App\Service\Tareas;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tareas;
use App\Repository\EstadoRepository;
use App\Repository\TareasRepository;
use App\Repository\UserRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class TareasService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    private UserRepository $userRepository;
    private ServicesRepository $servicesRepository;
    private EstadoRepository $estadoRepository;
    private TareasRepository $tareasRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        TareasRepository $tareasRepository,
        UserRepository $userRepository,
        ServicesRepository $servicesRepository,
        EstadoRepository $estadoRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->tareasRepository = $tareasRepository;
        $this->userRepository = $userRepository;
        $this->servicesRepository = $servicesRepository;
        $this->estadoRepository = $estadoRepository;
    }

    public function nuevaTarea($user): Tareas
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $nuevaTarea = new Tareas();
        $nuevaTarea->setTitulo(trim($data->titulo));
        $nuevaTarea->setDescripcion($data->descripcion);
        $servicio = $this->servicesRepository->find($data->servicio);
        $nuevaTarea->setUser($user);
        $nuevaTarea->setServicio($servicio);
        $estado = $this->estadoRepository->find('1');
        $nuevaTarea->setEstado($estado);
        $nuevaTarea->setTiempoTarea('0');
        $this->entityManager->persist($nuevaTarea);
        $this->entityManager->flush();
        return $nuevaTarea;
    }


    public function editarTarea()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->id);
        if (!$tarea) {
            return new Response('Tarea no existe', Response::HTTP_BAD_REQUEST);
        }
        $tarea->setTitulo(trim($data->titulo));
        $tarea->setDescripcion($data->descripcion);
        $this->entityManager->flush();
        return $tarea;
    }

    public function eliminarTarea()
    {

        $tarea = $this->tareasRepository->find($this->requestStack->getCurrentRequest()->get('id'));
        if (!$tarea) {
            return new Response('Tarea no existe', Response::HTTP_BAD_REQUEST);
        }
        $this->entityManager->remove($tarea);
        $this->entityManager->flush();
        return new Response('Tarea Eliminada', Response::HTTP_BAD_REQUEST);
    }

    public function actualizarEstado()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->id);
        if (!$tarea) {
            return new Response('Tarea no existe', Response::HTTP_BAD_REQUEST);
        }
        $estado = $this->estadoRepository->find($data->estado);
        $tarea->setEstado($estado);
        $this->entityManager->flush();
        return $tarea;
    }

    public function ingresarHorasTarea()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->id);
        if (!$tarea) {
            return new Response('Tarea no existe', Response::HTTP_BAD_REQUEST);
        }
        $servicioTarea = $tarea->getServicio();
        if (!$servicioTarea) {
            return new Response('Servicio no existe', Response::HTTP_BAD_REQUEST);
        }

        $hours_service = $servicioTarea->getHoursService();
        $horasRestantesServicio = $servicioTarea->getTimeRemaining();
        $tiempoTareasActual = $tarea->getTiempoTarea();
        $tiempoTareaNuevo = $data->horasTarea;


        if ($tiempoTareasActual > $tiempoTareaNuevo) {
            $tiempoServicio = $tiempoTareasActual - $tiempoTareaNuevo;

            if ((($horasRestantesServicio + $tiempoServicio) <= $hours_service)) {

                $nuevoTiempoRestante = $horasRestantesServicio + $tiempoServicio;
            } else {
                return new Response('El Servicio no cuenta con suficientes horas para asignar la tarea', Response::HTTP_BAD_REQUEST);
            }
        } else {
            $tiempoServicio = $tiempoTareaNuevo - $tiempoTareasActual;

            if (($horasRestantesServicio - $tiempoServicio) >= 0) {

                $nuevoTiempoRestante = $horasRestantesServicio - $tiempoServicio;
            } else {
                return new Response('El Servicio no cuenta con suficientes horas para asignar la tarea', Response::HTTP_BAD_REQUEST);
            }
        }
        $tarea->setTiempoTarea($data->horasTarea);
        $servicioTarea->setTimeRemaining($nuevoTiempoRestante);
        $this->entityManager->flush();
        return $tarea;
    }
}
