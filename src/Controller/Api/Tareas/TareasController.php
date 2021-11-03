<?php

namespace App\Controller\Api\Tareas;

use App\Repository\TareasRepository;
use App\Service\Tareas\TareasService;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TareasController extends AbstractController
{
    /**
     * @Rest\Get(path="/tareas")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAlltask(TareasRepository $tareasRepository)
    {
        return $tareasRepository->findAll();
    }

    /**
     * @Rest\Post(path="/tareas")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function postTareas(TareasService $tareasService)
    {
        return $tareasService->nuevaTarea($this->getUser());
    }

    /**
     * @Rest\get(path="/tareas_especificas_usuario")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllTareasUsuarioEspecifico(TareasRepository $tareasRepository)
    {
        return $tareasRepository->findBy(['user' => $this->getUser()]);
    }

    /**
     * @Rest\get(path="/get_all_task")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllTareas(TareasRepository $tareasRepository): array
    {
        return $tareasRepository->findAll();
    }

    /**
     * @Rest\get(path="/tareas_especificas/{usuario}/{servicio}")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function getTareasEspeficas(TareasRepository $tareasRepository, Request $request)
    {
        return $tareasRepository->findBy(['user' => $request->get('usuario'), 'servicio' => $request->get('servicio')]);
    }

    /**
     * @Rest\Put(path="/tareas")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function editTarea(TareasService $tareasService)
    {
        return $tareasService->editarTarea();
    }

    /**
     * @Rest\Delete(path="/tareas/{id}")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function eliminacionTarea(TareasService $tareasService)
    {
        return $tareasService->eliminarTarea();
    }

    /**
     * @Rest\put(path="/tareas_actualizar_estado")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function actualizarEstadoTarea(TareasService $tareasService)
    {
        return $tareasService->actualizarEstado();
    }

    /**
     * @Rest\put(path="/tareas_ingresar_horas")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function ingresarHoras(TareasService $tareasService)
    {
        return $tareasService->ingresarHorasTarea();
    }

    /**
     * @Rest\Get(path="/contador_mensajes_admin/{id}")
     * @Rest\View(serializerGroups={"tareas"}, serializerEnableMaxDepthChecks=true)
     */
    public function contadorMensajesAdmin(TareasRepository $tareasRepository, Request $request)
    {
        return $tareasRepository->contadorMensajesAdmin($request->get('id'));
    }
}
