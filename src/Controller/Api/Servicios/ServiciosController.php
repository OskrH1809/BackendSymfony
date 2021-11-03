<?php

namespace App\Controller\Api\Servicios;

use App\Repository\ServicesRepository;
use App\Service\Servicios\ServiciosService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ServiciosController extends AbstractController
{
    /**
     * @Rest\Get(path="/services")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServices(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findAll();
    }
    /**
     * @Rest\Get(path="/services_search/{search}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getSearchServices(ServiciosService $serviceManagement)
    {
        return $serviceManagement->searchService();
    }



    /**
     * @Rest\Post(path="/services")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function postServices(ServiciosService $serviceManagement): \App\Entity\Services
    {
        return $serviceManagement->newService();
    }

    /**
     * @Rest\Get(path="/service_specific/{id}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getService(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findBy(['id' => $request->get('id')]);
    }

    /**
     * @Rest\Put(path="/services/{id}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putServices(ServiciosService $serviceManagement)
    {
        return $serviceManagement->editService();
    }

    /**
     * @Rest\Put(path="/activar_servicios")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putActivarServicios(ServiciosService $serviceManagement)
    {
        return $serviceManagement->activarServicio();
    }

    /**
     * @Rest\Put(path="/desactivar_servicios")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function putDesactivarServicios(ServiciosService $serviceManagement)
    {
        return $serviceManagement->desactivarServicio();
    }

    /**
     * @Rest\Delete(path="/services/{id}")
     */
    public function deleteServices(ServiciosService $serviceManagement): \FOS\RestBundle\View\View
    {
        return $serviceManagement->deleteService();
    }

    /**
     * @Rest\Post(path="/pay_service")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServices(ServicesRepository $servicesRepository, Request $request): array
    {
        return $servicesRepository->findPayServices($request);
    }


    /**
     * @Rest\Get(path="/pay_service_by_user")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServicesByUser(ServicesRepository $servicesRepository): array
    {
        return $servicesRepository->findPayServicesByUser($this->getUser()->getId());
    }
}
