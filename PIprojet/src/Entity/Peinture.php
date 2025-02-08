<?php

namespace App\Entity;

use App\Repository\PeintureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeintureRepository::class)]
class Peinture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_cr = null;

    #[ORM\Column(length: 255)]
    private ?string $tableau = null;

    #[ORM\ManyToOne(inversedBy: 'peintures')]
    private ?Style $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateCr(): ?\DateTimeInterface
    {
        return $this->date_cr;
    }

    public function setDateCr(\DateTimeInterface $date_cr): static
    {
        $this->date_cr = $date_cr;

        return $this;
    }

    public function getTableau(): ?string
    {
        return $this->tableau;
    }

    public function setTableau(string $tableau): static
    {
        $this->tableau = $tableau;

        return $this;
    }

    public function getType(): ?Style
    {
        return $this->type;
    }

    public function setType(?Style $type): static
    {
        $this->type = $type;

        return $this;
    }
}
