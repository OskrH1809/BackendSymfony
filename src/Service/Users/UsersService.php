<?php


namespace App\Service\Users;


use App\Entity\User;
use App\Repository\PerfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UsersService
{
    private EntityManagerInterface $em;
    private RequestStack $rs;
    private UserPasswordHasherInterface $userPasswordEncoder;
    private UserRepository $userRepository;
    private PerfilRepository $perfilRepository;
    private MailerInterface $mailer;

    public function __construct(
        EntityManagerInterface $em,
        RequestStack $rs,
        UserPasswordHasherInterface $userPasswordEncoder,
        UserRepository $userRepository,
        PerfilRepository $perfilRepository,
        MailerInterface $mailer
    ) {
        $this->em = $em;
        $this->rs = $rs;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->userRepository = $userRepository;
        $this->perfilRepository = $perfilRepository;
        $this->mailer = $mailer;
    }

    public function registerUser(): View
    {
        $req = json_decode($this->rs->getCurrentRequest()->getContent());
        $userByEmail = $this->userRepository->findOneByEmail($req->email);
        if ($userByEmail) {
            return View::create('A user with this email already exists.', Response::HTTP_BAD_REQUEST);
        }
        $user = new User();
        $user->setEmail($req->email);
        $user->setPassword($this->userPasswordEncoder->hashPassword($user, $req->password));
        $perfil = $this->perfilRepository->find($req->perfil);
        if (empty($perfil)) {
            $perfil = $this->perfilRepository->find('3');
        }
        $user->setPerfil($perfil);
        $user->setActivo('1');
        $this->em->persist($user);
        $this->em->flush();
        return View::create($user, Response::HTTP_OK);
    }


    public function sendEmailNewUser()
    {
        $numeroAleatorio = mt_rand(100000000000, 100000000000000);
        $req = json_decode($this->rs->getCurrentRequest()->getContent());
        $userByEmail = $this->userRepository->findOneByEmail($req->email);
        if ($userByEmail) {
            return new Response('A user with this email already exists.', Response::HTTP_BAD_REQUEST);
        }
        $user = new User();
        $user->setEmail($req->email);
        $user->setPassword($this->userPasswordEncoder->hashPassword($user, $numeroAleatorio));
        $perfil = $this->perfilRepository->find($req->perfil);
        if (empty($perfil)) {
            $perfil = $this->perfilRepository->find('3');
        }
        $user->setPerfil($perfil);
        $user->setActivo('1');
        $this->em->persist($user);
        $this->em->flush();
        $email = (new Email())
            ->from('contratacionservicios150@gmail.com')
            ->to($req->email)
            ->subject('Nuevo registro de usuario!')
            ->text('Le damos la bienvenida a la paginas de servicios')
            ->html('<p>' . 'Su correo para ingresar a la pagina de Servicios es: ' . $req->email . ' y la contraseña es: ' . $numeroAleatorio . '</p>');
        $this->mailer->send($email);
        return View::create($user, Response::HTTP_OK);
    }


    public function activarUsuario()
    {
        $data = json_decode($this->rs->getCurrentRequest()->getContent());
        $user = $this->userRepository->find($data->user);
        if (!$user) {
            return View::create('Usuario no existe', Response::HTTP_BAD_REQUEST);
        }
        $user->setActivo('1');
        $this->em->flush();

        return View::create($user, Response::HTTP_OK);
    }
    public function DesactivarUsuario()
    {
        $data = json_decode($this->rs->getCurrentRequest()->getContent());
        $user = $this->userRepository->find($data->user);
        if (!$user) {
            return View::create('Usuario no existe', Response::HTTP_BAD_REQUEST);
        }
        $user->setActivo('0');
        $this->em->flush();

        return View::create($user, Response::HTTP_OK);
    }

    public function updatePassword($user)
    {
        $data = json_decode($this->rs->getCurrentRequest()->getContent());
        $passwordValid = $this->userPasswordEncoder->isPasswordValid($user, $data->passwordCurrent);
        if (!$passwordValid) {
            return View::create('Contraseña actual incorrecta', Response::HTTP_BAD_REQUEST);
        }

        $user->setPassword($this->userPasswordEncoder->hashPassword($user, $data->password));
        $this->em->flush();
        return View::create('La contraseña se ha actualizado con éxito', Response::HTTP_OK);
    }

    public function recoverPassword()
    {
        $numeroAleatorio = mt_rand(100000000000, 100000000000000);
        $req = json_decode($this->rs->getCurrentRequest()->getContent());
        $userByEmail = $this->userRepository->findOneByEmail($req->email);
        if (!$userByEmail) {
            return new Response('El correo no existe.', Response::HTTP_BAD_REQUEST);
        }
        $userByEmail->setPassword($this->userPasswordEncoder->hashPassword($userByEmail, $numeroAleatorio));
        $this->em->flush();
        $email = (new Email())
            ->from('contratacionservicios150@gmail.com')
            ->to($req->email)
            ->subject('Recuperación de contraseña.')
            ->text('Le damos la bienvenida a la paginas de servicios')
            ->html('<p>' . 'Hola ' . $req->email . ' su nueva contraseña para ingresar al sitio web es: ' . $numeroAleatorio . '</p>');
        $this->mailer->send($email);
        return View::create('Revise su correo.', Response::HTTP_OK);
    }
}
