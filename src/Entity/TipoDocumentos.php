<?php

namespace App\Entity;

use App\Repository\TipoDocumentosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TipoDocumentosRepository::class)
 */
class TipoDocumentos
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
     * @ORM\OneToMany(targetEntity=Documentos::class, mappedBy="tipo")
     */
    private $documentos;

    public function __construct()
    {
        $this->documentos = new ArrayCollection();
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

    /**
     * @return Collection|Documentos[]
     */
    public function getDocumentos(): Collection
    {
        return $this->documentos;
    }

    public function addDocumento(Documentos $documento): self
    {
        if (!$this->documentos->contains($documento)) {
            $this->documentos[] = $documento;
            $documento->setTipo($this);
        }

        return $this;
    }

    public function removeDocumento(Documentos $documento): self
    {
        if ($this->documentos->removeElement($documento)) {
            // set the owning side to null (unless already changed)
            if ($documento->getTipo() === $this) {
                $documento->setTipo(null);
            }
        }

        return $this;
    }
}
