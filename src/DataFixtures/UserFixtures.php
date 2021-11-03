<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\PerfilRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;
    private PerfilRepository $perfilRepository;

    public function __construct(UserPasswordHasherInterface $hasher, PerfilRepository $perfilRepository)
    {
        $this->hasher = $hasher;
        $this->perfilRepository = $perfilRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users = new User();
        $users->setEmail('admin@hb.es');
        $users->setActivo(1);
        $users->setPerfil($this->perfilRepository->findOneBy(['nombre'=>'ROLE_ADMIN']));
        $users->setPassword($this->hasher->hashPassword($users, 'admin123'));
        $manager->persist($users);
        $users = new User();
        $users->setEmail('agent@hb.es');
        $users->setActivo(1);
        $users->setPerfil($this->perfilRepository->findOneBy(['nombre'=>'ROLE_AGENT']));
        $users->setPassword($this->hasher->hashPassword($users, 'agent123'));
        $manager->persist($users);
        $users = new User();
        $users->setEmail('client@hb.es');
        $users->setActivo(1);
        $users->setPerfil($this->perfilRepository->findOneBy(['nombre'=>'ROLE_CLIENT']));
        $users->setPassword($this->hasher->hashPassword($users, 'client123'));
        $manager->persist($users);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PerfilFixtures::class,
        ];
    }
}
