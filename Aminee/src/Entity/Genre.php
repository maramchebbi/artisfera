<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @var Collection<int, SignUp>
     */
    #[ORM\OneToMany(targetEntity: SignUp::class, mappedBy: 'genre')]
    private Collection $genr;

    #[ORM\Column(length: 255)]
    private ?string $g = null;

    public function __construct()
    {
        $this->genr = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * @return Collection<int, SignUp>
     */
    public function getGenr(): Collection
    {
        return $this->genr;
    }

    public function addGenr(SignUp $genr): static
    {
        if (!$this->genr->contains($genr)) {
            $this->genr->add($genr);
            $genr->setGenre($this);
        }

        return $this;
    }

    public function removeGenr(SignUp $genr): static
    {
        if ($this->genr->removeElement($genr)) {
            // set the owning side to null (unless already changed)
            if ($genr->getGenre() === $this) {
                $genr->setGenre(null);
            }
        }

        return $this;
    }

    public function getG(): ?string
    {
        return $this->g;
    }

    public function setG(string $g): static
    {
        $this->g = $g;

        return $this;
    }
}
