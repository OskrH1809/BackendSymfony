<?php

namespace App\Entity;

use App\Repository\ContratedServicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContratedServicesRepository::class)
 */
class ServiciosContratados
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contratedServices")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Services::class, inversedBy="contratedServices")
     */
    private $servicio;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $periodo_pago;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;



    public function __construct()
    {
        $this->setCreateAt(new \DateTime("now"));
      
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getServicio(): ?Services
    {
        return $this->servicio;
    }

    public function setServicio(?Services $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }



    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function setActivo(?string $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getPeriodoPago(): ?string
    {
        return $this->periodo_pago;
    }

    public function setPeriodoPago(?string $periodo_pago): self
    {
        $this->periodo_pago = $periodo_pago;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    
  

   

    
}
