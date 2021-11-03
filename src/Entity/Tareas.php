<?php

namespace App\Entity;

use App\Repository\TareasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TareasRepository::class)
 */
class Tareas
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
    private $titulo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity=Services::class, inversedBy="tareas")
     */
    private $servicio;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tiempo_tarea;

    /**
     * @ORM\ManyToOne(targetEntity=Estado::class, inversedBy="tareas")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="tarea")
     */
    private $conversations;

  

    

    public function __construct()
    {
        $this->conversations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTiempoTarea(): ?int
    {
        return $this->tiempo_tarea;
    }

    public function setTiempoTarea(?int $tiempo_tarea): self
    {
        $this->tiempo_tarea = $tiempo_tarea;

        return $this;
    }

    public function getEstado(): ?Estado
    {
        return $this->estado;
    }

    public function setEstado(?Estado $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setTarea($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getTarea() === $this) {
                $conversation->setTarea(null);
            }
        }

        return $this;
    }

 

}
