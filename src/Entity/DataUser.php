<?php

namespace App\Entity;

use App\Repository\DataUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DataUserRepository::class)
 */
class DataUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cuentaBanco;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dataUsers")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuentaBanco(): ?string
    {
        return $this->cuentaBanco;
    }

    public function setCuentaBanco(?string $cuentaBanco): self
    {
        $this->cuentaBanco = $cuentaBanco;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
