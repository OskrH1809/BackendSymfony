<?php

namespace App\Controller\Api\DataUser;

use App\Repository\DataUserRepository;
use App\Service\DataUser\DataUserService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataUserController extends AbstractController
{
    /**
     * @Rest\Get(path="/data_users")
     * @Rest\View(serializerGroups={"data"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllData(DataUserRepository $dataUserRepository)
    {
        return $dataUserRepository->findAll();
    }

    /**
     * @Rest\Get(path="/data_this_user")
     * @Rest\View(serializerGroups={"data"}, serializerEnableMaxDepthChecks=true)
     */
    public function getDataThisUser(DataUserRepository $dataUserRepository)
    {
        return $dataUserRepository->findOneBy(['user' => $this->getUser()]);
    }

    /**
     * @Rest\Post(path="/new_data_this_user")
     * @Rest\View(serializerGroups={"data"}, serializerEnableMaxDepthChecks=true)
     */
    public function newDataThisUser(DataUserService $DataUserService)
    {
        return $DataUserService->newDataUser($this->getUser());
    }

    /**
     * @Rest\Put(path="/edit_data_this_user")
     * @Rest\View(serializerGroups={"data"}, serializerEnableMaxDepthChecks=true)
     */
    public function editDataThisUser(DataUserService $DataUserService)
    {
        return $DataUserService->EditarDatosUsuario($this->getUser());
    }
}
