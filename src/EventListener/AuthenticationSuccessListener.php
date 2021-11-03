<?php


namespace App\EventListener;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        
        if (!$user instanceof User) {
            return;
        }
        if (!$user->getActivo()) {
            $event->setData(['code' => 401, 'message' => 'Inactive account']);
            $event->getResponse()->setStatusCode(401);
            return;
        }
        $data['data'] = ['role' => $user->getPerfil()->getNombre(), 'perfilId' => $user->getPerfil()->getId(), 'username' => $user->getUsername(),'id' => $user->getId() ?? 'None'];
        $event->setData($data);
    }
}
