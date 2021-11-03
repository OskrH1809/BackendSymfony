<?php

namespace App\DataFixtures;

use App\Entity\Estado;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EstadoFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->createEstatus($manager);
    }

    private function createEstatus(ObjectManager $manager): void
    {
        $estado = new Estado();
        $estado->setName('Creado');
        $manager->persist($estado);
        $estado = new Estado();
        $estado->setName('En revisión');
        $manager->persist($estado);
        $estado = new Estado();
        $estado->setName('Finalizado');
        $manager->persist($estado);
        $manager->flush();
    }

}
