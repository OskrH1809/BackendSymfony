<?php


namespace App\Controller\Api\Users;

use App\Repository\UserRepository;
use App\Service\Users\UsersService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{

    /**
     * @Rest\Get(path="/users")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllUsers(UserRepository $userRepository): array
    {
        return $userRepository->findAll();
    }

    /**
     * @Rest\Get(path="/usuarios_select")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function usersAll(UserRepository $userRepository): array
    {
        return $userRepository->usuariosAll();
    }

    /**
     * @Rest\Post(path="/register")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function registerUser(UsersService $usersService): \FOS\RestBundle\View\View
    {
        return $usersService->registerUser();
    }


    /**
     * @Rest\Post(path="/send_email")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function sendEmailNewUser(UsersService $usersService)
    {

        return $usersService->sendEmailNewUser();
    }

    /**
     * @Rest\Put(path="/desactivar_usuario")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function desactivarUsuario(UsersService $usersService)
    {

        return $usersService->desactivarUsuario();
    }

    /**
     * @Rest\Put(path="/activar_usuario")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function activarUsuario(UsersService $usersService)
    {

        return $usersService->activarUsuario();
    }

    /**
     * @Rest\Put(path="/edit_password")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function updatePasswordUser(UsersService $usersService)
    {
        return $usersService->updatePassword($this->getUser());
    }

    /**
     * @Rest\Post(path="/recuperar")
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function recoverPassword(UsersService $usersService)
    {
        return $usersService->recoverPassword();
    }
}
