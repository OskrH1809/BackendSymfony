<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="conversation")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Tareas::class, inversedBy="conversations")
     */
    private $tarea;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setConversation($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getConversation() === $this) {
                $comment->setConversation(null);
            }
        }

        return $this;
    }

    public function getTarea(): ?Tareas
    {
        return $this->tarea;
    }

    public function setTarea(?Tareas $tarea): self
    {
        $this->tarea = $tarea;

        return $this;
    }
}
