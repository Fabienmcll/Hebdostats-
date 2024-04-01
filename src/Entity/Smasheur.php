<?php

namespace App\Entity;

use App\Repository\SmasheurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SmasheurRepository::class)
 */
#[ORM\Entity(repositoryClass:SmasheurRepository::class)]
class Smasheur
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
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $tag;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[ORM\Column(type:"integer", nullable:true)]
    private $IdPlayerAPI;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $personnages;

    /**
     * @ORM\OneToMany(targetEntity=Tournoi::class, mappedBy="smasheur")
     * @ORM\OrderBy({"NumSaucisse" = "ASC"})
     */
    #[ORM\OneToMany(targetEntity:Tournoi::class, mappedBy:"smasheur")]
    #[ORM\OrderBy(["NumSaucisse" => "ASC"])]
    private $tournois;

    public function __construct()
    {
        $this->tournois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getIdPlayerAPI(): ?int
    {
        return $this->IdPlayerAPI;
    }

    public function setIdPlayerAPI(?int $IdPlayerAPI): self
    {
        $this->IdPlayerAPI = $IdPlayerAPI;

        return $this;
    }

    public function getPersonnages(): ?string
    {
        return $this->personnages;
    }
    public function setPersonnages(?string $personnages): self
    {
        $this->personnages = $personnages;

        return $this;
    }
    /**
     * @return Collection<int, Tournoi>
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }
    public function arrayNumSaucisse(): array
    {
        $retour = array();
        foreach ($this->tournois as $tournoi)
        {
            $retour[] =$tournoi->getNumSaucisse();
        }
        return $retour;
    }

    public function addTournoi(Tournoi $tournoi): self
    {
        if (!$this->tournois->contains($tournoi)) {
            $this->tournois[] = $tournoi;
            $tournoi->setSmasheur($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            // set the owning side to null (unless already changed)
            if ($tournoi->getSmasheur() === $this) {
                $tournoi->setSmasheur(null);
            }
        }

        return $this;
    }
}
