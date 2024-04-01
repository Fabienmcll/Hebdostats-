<?php

namespace App\Entity;

use App\Repository\TournoiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournoiRepository::class)
 */
#[ORM\Entity(repositoryClass:TournoiRepository::class)]
class Tournoi
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
     * @ORM\Column(type="integer")
     */
    #[ORM\Column(type:"integer")]
    private $NumSaucisse;


    /**
     * @ORM\ManyToOne(targetEntity=Smasheur::class, inversedBy="tournois")
     */
    #[ORM\ManyToOne(targetEntity:Smasheur::class, inversedBy:"tournois")]
    private $smasheur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSaucisse(): ?string
    {
        return $this->NumSaucisse;
    }

    public function setNumSaucisse(string $NumSaucisse): self
    {
        $this->NumSaucisse = $NumSaucisse;

        return $this;
    }


    public function getSmasheur(): ?Smasheur
    {
        return $this->smasheur;
    }

    public function setSmasheur(?Smasheur $smasheur): self
    {
        $this->smasheur = $smasheur;

        return $this;
    }
}
