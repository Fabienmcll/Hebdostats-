<?php

namespace App\Entity;

use App\Repository\AnecdoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnecdoteRepository::class)
 * @ORM\Table (name="anecdotes")
 */
#[ORM\Entity(repositoryClass:AnecdoteRepository::class)]
#[ORM\Table (name:"anecdotes")]
class Anecdote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[ORM\Column(type:"text", nullable:true)]
    private $body;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }
}
