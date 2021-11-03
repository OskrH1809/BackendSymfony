<?php


namespace App\Service\DataUser;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\DataUser;
use App\Repository\DataUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class DataUserService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    private DataUserRepository $dataUserRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        DataUserRepository $dataUserRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->dataUserRepository = $dataUserRepository;
    }


    public function newDataUser($user)
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $dataUser = new DataUser();
        $dataUser->setCuentaBanco($data->cuentaBanco);
        $dataUser->setDireccion($data->direccion);
        $dataUser->setTelefono($data->telefono);
        $dataUser->setUser($user);
        $this->entityManager->persist($dataUser);
        $this->entityManager->flush();
        return $dataUser;
    }

    public function EditarDatosUsuario($user)
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $dataUser = $this->dataUserRepository->findOneBy(['user' => $user]);
        if (!$dataUser) {
            return new Response('error al actualizar los datos', Response::HTTP_BAD_REQUEST);
        }
        $dataUser->setCuentaBanco($data->cuentaBanco);
        $dataUser->setDireccion($data->direccion);
        $dataUser->setTelefono($data->telefono);
        $this->entityManager->flush();
        return $dataUser;
    }
}
