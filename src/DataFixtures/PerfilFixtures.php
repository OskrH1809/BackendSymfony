<?php

namespace App\DataFixtures;

use App\Entity\Perfil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PerfilFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->createPerfils($manager);
    }

    private function createPerfils(ObjectManager $manager): void
    {
        $perfiles = new Perfil();
        $perfiles->setNombre('ROLE_ADMIN');
        $perfiles->setAcceso(1);
        $manager->persist($perfiles);
        $perfiles = new Perfil();
        $perfiles->setNombre('ROLE_AGENT');
        $perfiles->setAcceso(10);
        $manager->persist($perfiles);
        $perfiles = new Perfil();
        $perfiles->setNombre('ROLE_CLIENT');
        $perfiles->setAcceso(20);
        $manager->persist($perfiles);
        $manager->flush();
    }

}
