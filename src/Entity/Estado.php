<?php

namespace App\Entity;

use App\Repository\EstadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstadoRepository::class)
 */
class Estado
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
     * @ORM\OneToMany(targetEntity=Tareas::class, mappedBy="estado")
     */
    private $tareas;

    public function __construct()
    {
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
            $tarea->setEstado($this);
        }

        return $this;
    }

    public function removeTarea(Tareas $tarea): self
    {
        if ($this->tareas->removeElement($tarea)) {
            // set the owning side to null (unless already changed)
            if ($tarea->getEstado() === $this) {
                $tarea->setEstado(null);
            }
        }

        return $this;
    }
}
