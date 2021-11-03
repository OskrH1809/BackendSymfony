<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesRepository::class)
 */
class Services
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
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=ServiciosContratados::class, mappedBy="servicio")
     */
    private $contratedServices;

    /**
     * @ORM\OneToMany(targetEntity=Tareas::class, mappedBy="servicio")
     */
    private $tareas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hours_service;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $time_remaining;

    public function __construct()
    {
        $this->setDate(new \DateTime("now"));
        $this->contratedServices = new ArrayCollection();
        $this->tareas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|ServiciosContratados[]
     */
    public function getContratedServices(): Collection
    {
        return $this->contratedServices;
    }

    public function addContratedService(ServiciosContratados $contratedService): self
    {
        if (!$this->contratedServices->contains($contratedService)) {
            $this->contratedServices[] = $contratedService;
            $contratedService->setServicio($this);
        }

        return $this;
    }

    public function removeContratedService(ServiciosContratados $contratedService): self
    {
        if ($this->contratedServices->removeElement($contratedService)) {
            // set the owning side to null (unless already changed)
            if ($contratedService->getServicio() === $this) {
                $contratedService->setServicio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tareas[]
     */
    public function getTareas(): Collection
    {
        return $this->tareas;
    }

    public function addTarea(Tareas $tarea): self
    {
        if (!$this->tareas->contains($tarea)) {
            $this->tareas[] = $tarea;
            $tarea->setServicio($this);
        }

        return $this;
    }

    public function removeTarea(Tareas $tarea): self
    {
        if ($this->tareas->removeElement($tarea)) {
            // set the owning side to null (unless already changed)
            if ($tarea->getServicio() === $this) {
                $tarea->setServicio(null);
            }
        }

        return $this;
    }

    public function getActivo(): ?string
    {
        return $this->activo;
    }

    public function setActivo(string $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getHoursService(): ?string
    {
        return $this->hours_service;
    }

    public function setHoursService(string $hours_service): self
    {
        $this->hours_service = $hours_service;

        return $this;
    }

    public function getTimeRemaining(): ?int
    {
        return $this->time_remaining;
    }

    public function setTimeRemaining(?int $time_remaining): self
    {
        $this->time_remaining = $time_remaining;

        return $this;
    }

    
}
