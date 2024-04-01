<?php

namespace App\Entity;

use App\Repository\TropheeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TropheeRepository::class)
 */
#[ORM\Entity(repositoryClass:TropheeRepository::class)]
class Trophee
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $version;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    #[ORM\Column(type:"bigint", nullable:true)]
    private $idPlayerAPI;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $emoji;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getIdPlayerAPI(): ?string
    {
        return $this->idPlayerAPI;
    }

    public function setIdPlayerAPI(?string $idPlayerAPI): self
    {
        $this->idPlayerAPI = $idPlayerAPI;

        return $this;
    }

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
