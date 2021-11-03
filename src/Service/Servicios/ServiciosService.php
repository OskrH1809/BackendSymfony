<?php

namespace App\Service\Servicios;

use App\Entity\Services;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class ServiciosService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var ServicesRepository
     */
    private ServicesRepository $servicesRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        ServicesRepository $servicesRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->servicesRepository = $servicesRepository;
    }

    public function newService(): Services
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $newService = new Services();
        $newService->setName(trim($data->name));
        $newService->setPrice($data->price);
        $newService->setActivo('1');
        $newService->setHoursService($data->horasServicio);
        $newService->setTimeRemaining($data->horasServicio);
        $this->entityManager->persist($newService);
        $this->entityManager->flush();
        return $newService;
    }

    public function editService()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $service = $this->servicesRepository->find($request->get('id'));
        if (!$service) {
            return  View::create('ko!', Response::HTTP_BAD_REQUEST);
        }
        $service->setName(trim($data->name));
        $service->setPrice($data->price);
        $service->setHoursService($data->horasServicio);
        $this->entityManager->flush();
        return $service;
    }


    public function deleteService(): View
    {
        $service = $this->servicesRepository->find($this->requestStack->getCurrentRequest()->get('id'));
        if (!$service) {
            return  View::create('ko!', Response::HTTP_BAD_REQUEST);
        }
        $this->entityManager->remove($service);
        $this->entityManager->flush();
        return  View::create('ok!', Response::HTTP_OK);
    }


    public function searchService()
    {
        $parametro =  $this->requestStack->getCurrentRequest()->get('search');
        $search = $this->servicesRepository->createQueryBuilder('servicio')
            ->orWhere('servicio.name LIKE :parametro')
            ->orWhere('servicio.price LIKE :parametro')
            ->orWhere('servicio.id LIKE :parametro')
            ->setParameter('parametro', '%' . $parametro . '%')
            ->getQuery()
            ->execute();
        return $search;
    }


    public function activarServicio()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $service = $this->servicesRepository->find($data->servicio);
        if (!$service) {
            return  View::create('Servicio no existe', Response::HTTP_BAD_REQUEST);
        }
        $service->setActivo('1');
        $this->entityManager->flush();
        return  View::create('Servicio activado', Response::HTTP_OK);
    }
    public function desactivarServicio()
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = json_decode($request->getContent());
        $service = $this->servicesRepository->find($data->servicio);
        if (!$service) {
            return  View::create('Servicio no existe', Response::HTTP_BAD_REQUEST);
        }
        $service->setActivo('0');
        $this->entityManager->flush();
        return  View::create('Servicio desactivado', Response::HTTP_OK);
    }
}
