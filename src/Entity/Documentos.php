<?php

namespace App\Entity;

use App\Repository\DocumentosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentosRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Documentos
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ruta;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumentos::class, inversedBy="documentos")
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $dependent;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $Visualizar;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $aprobado;

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

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(string $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }

    public function getTipo(): ?TipoDocumentos
    {
        return $this->tipo;
    }

    public function setTipo(?TipoDocumentos $tipo): self
    {
        $this->tipo = $tipo;

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getDependent(): ?int
    {
        return $this->dependent;
    }

    public function setDependent(int $dependent): self
    {
        $this->dependent = $dependent;

        return $this;
    }

    /**
     * @throws \Exception
     * @ORM\PrePersist()
     */
    public function beforeSave()
    {

        $this->createAt = new \DateTime('now');
    }

    /**
     * @throws \Exception
     * @ORM\PreUpdate()
     */
    public function beforeUpdate()
    {

        $this->updateAt = new \DateTime('now');
    }

    public function getAprobado(): ?int
    {
        return $this->aprobado;
    }

    public function setAprobado(?int $aprobado): self
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    public function getVisualizar()
    {
        return $this->Visualizar;
    }

  
    public function setVisualizar($Visualizar)
    {
        $this->Visualizar = $Visualizar;

        return $this;
    }
}
