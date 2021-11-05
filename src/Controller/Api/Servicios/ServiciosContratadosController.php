<?php

namespace App\Controller\Api\Servicios;


use App\Service\Contracted\ContractedService;
use App\Repository\ContratedServicesRepository;
use DateTime;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ServiciosContratadosController extends AbstractController
{
    /**
     * @Rest\Get(path="/contrated_services")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServices(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findAll();
    }


    /**
     * @Rest\Get(path="/services_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServicesByUser(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findBy(['user' => $this->getUser()]);
    }

    /**
     * @Rest\Get(path="/servicios_contratados_usuario_especifico/{username}")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getServiciosContratadosUsuarioEspeficio(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        $data = json_decode($request->getContent());

        return $contratedServicesRepository->findBy(['user' => $request->get('username')]);
    }

  

    /**
     * @Rest\Post(path="/new_contrated")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function nuevaContratacionServicios(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->nuevaContratacionServicios();
    }

    /**
     * @Rest\Post(path="/new_contrated_optional")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function nuevaContratacionServiciosOpcional(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->nuevaContratacionServiciosOpcional();
    }

    /**
     * @Rest\Post(path="/count_documents_services_contracted")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function CountDocumemntsServicesContracted(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        return $contratedServicesRepository->countDocumentsServiceContracted($request);
    }



    /**
     * @Rest\Put(path="/activar_servicio_contratado")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function activarServicioContratado(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->activarServicioContratado();
    }

    /**
     * @Rest\Put(path="/desactivar_servicio_contratado")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function desactivarServicioContratado(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->desactivarServicioContratado();
    }

    /**
     * @Rest\Get(path="/clientes_de_servicio/{servicio}")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getClientesDeServicio(ContratedServicesRepository $contratedServicesRepository, Request $request)
    {
        return $contratedServicesRepository->findBy(['servicio' => $request->get('servicio')]);
    }

    /**
     * @Rest\Put(path="/periodo_pago")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function cambiarPeriodoPago(ContractedService $ContractedServiceManagement)
    {
        return $ContractedServiceManagement->cambiarPeriodoPagoServicioContratado();
    }

    /**
     * @Rest\Get(path="/pay_service_all")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function getPayServicesall(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->findPayServicesAll();
    }

    /**
     * @Rest\Get(path="/sin_aprobar")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function sinAprobar(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosSinAprobar();
    }

    /**
     * @Rest\Get(path="/pendientes_aprobacion")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function pendientesDeAprobacion(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosPendientesDeAprobar();
    }

    /**
     * @Rest\Get(path="/aprobados")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function aprobados(ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadosAprobados();
    }

    // by User

    /**
     * @Rest\Post(path="/sin_aprobar_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function sinAprobarByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosSinAprobarByUser($request);
    }

    /**
     * @Rest\Post(path="/pendientes_aprobacion_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function pendientesDeAprobacionByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosPendientesDeAprobarByUser($request);
    }

    /**
     * @Rest\Post(path="/aprobados_by_user")
     * @Rest\View(serializerGroups={"contrated"}, serializerEnableMaxDepthChecks=true)
     */
    public function aprobadosByUser(ContratedServicesRepository $contratedServicesRepository, Request $request): array
    {
        return $contratedServicesRepository->serviciosContratadosAprobadosByUser($request);
    }


     /**
     * @Rest\Get(path="/servicios_contratados_fechas/{fecha1}/{fecha2}")
     * @Rest\View(serializerGroups={"service"}, serializerEnableMaxDepthChecks=true)
     */
    public function topServicioEntreFechas(Request $request, ContratedServicesRepository $contratedServicesRepository): array
    {
        return $contratedServicesRepository->serviciosContratadoEntreFechas(new DateTime($request->get('fecha1')), new DateTime($request->get('fecha2')));
    }

}
