<?php

namespace App\Service\Contracted;

use App\Entity\ServiciosContratados;
use App\Repository\ContratedServicesRepository;
use App\Repository\ServicesRepository;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\FormFactoryInterface;

class ContractedService
{

    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;
    private UserRepository $userRepository;
    private ContratedServicesRepository $contratedServicesRepository;
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactoryInterface;
    private ServicesRepository $servicesRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        UserRepository $userRepository,
        ContratedServicesRepository $contratedServicesRepository,
        FileUploader $fileUploader,
        FormFactoryInterface $formFactoryInterface,
        ServicesRepository $servicesRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
        $this->contratedServicesRepository = $contratedServicesRepository;
        $this->fileUploader = $fileUploader;
        $this->formFactoryInterface = $formFactoryInterface;
        $this->servicesRepository = $servicesRepository;
    }

    public function getServiciosContratadoUsuarioEspecifico($user)
    {
        return $this->contratedServicesRepository->findBy(['user' => $user]);
    }


    public function nuevaContratacionServicios()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $user = $this->userRepository->find($data->usuario);
        $servicio = $this->servicesRepository->find($data->servicio);
       
        $contractedService = new ServiciosContratados();
        $verificar = $this->contratedServicesRepository->findBy(['user' => $user, 'servicio' => $servicio]);

        if ($servicio->getActivo() == '0') {
            return View::create('El Servicio: ' . $servicio->getName() . ' se encuentra desactivado', Response::HTTP_BAD_REQUEST);
        }

        if ($verificar) {
            return View::create('El Servicio: ' . $servicio->getName() . ' ya se encuentra contratado', Response::HTTP_BAD_REQUEST);
        }
        $contractedService->setUser($user);
        $contractedService->setServicio($servicio);
        $contractedService->setPeriodoPago('1');
        $contractedService->setActivo('1');
        $this->entityManager->persist($contractedService);
        $this->entityManager->flush();
        return $contractedService;
    }

    public function nuevaContratacionServiciosOpcional()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $user = $this->userRepository->findOneByEmail($data->email);
        $servicio = $this->servicesRepository->find($data->servicio);
        $contractedService = new ServiciosContratados();
        $verificar = $this->contratedServicesRepository->findBy(['user' => $user, 'servicio' => $servicio]);

        if ($servicio->getActivo() == '0') {
            return View::create('El Servicio: ' . $servicio->getName() . ' se encuentra desactivado', Response::HTTP_BAD_REQUEST);
        }

        if ($verificar) {
            return View::create('El Servicio: ' . $servicio->getName() . ' ya se encuentra contratado', Response::HTTP_BAD_REQUEST);
        }
        $contractedService->setUser($user);
        $contractedService->setServicio($servicio);
        $contractedService->setActivo('1');
        $contractedService->setPeriodoPago('1');
        $this->entityManager->persist($contractedService);
        $this->entityManager->flush();
        return $contractedService;
    }



    public function activarServicioContratado()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $contratedServices = $this->contratedServicesRepository->find($data->servicioContratado);
        if (!$contratedServices) {
            return new Response('servicio contratado no existe', Response::HTTP_BAD_REQUEST);
        }
        $contratedServices->setActivo('1');
        $this->entityManager->flush();
        return $contratedServices;
    }

    public function desactivarServicioContratado()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $contratedServices = $this->contratedServicesRepository->find($data->servicioContratado);
        if (!$contratedServices) {
            return new Response('servicio contratado no existe', Response::HTTP_BAD_REQUEST);
        }
        $contratedServices->setActivo('0');
        $this->entityManager->flush();
        return $contratedServices;
    }

    public function cambiarPeriodoPagoServicioContratado()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $contratedServices = $this->contratedServicesRepository->find($data->servicioContratado);
        if (!$contratedServices) {
            return new Response('servicio contratado no existe', Response::HTTP_BAD_REQUEST);
        }
        $contratedServices->setPeriodoPago('2');
        $this->entityManager->flush();
        return $contratedServices;
    }
}
