<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerfilRepository::class)
 */
class Perfil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private int $acceso;



    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAcceso(): ?int
    {
        return $this->acceso;
    }

    public function setAcceso(int $acceso): self
    {
        $this->acceso = $acceso;

        return $this;
    }

}
