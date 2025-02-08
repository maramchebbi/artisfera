<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, SignUp>
     */
    #[ORM\OneToMany(targetEntity: SignUp::class, mappedBy: 'type')]
    private Collection $typeUser;

    #[ORM\Column(length: 255)]
    private ?string $T = null;

    public function __construct()
    {
        $this->typeUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, SignUp>
     */
    public function getTypeUser(): Collection
    {
        return $this->typeUser;
    }

    public function addTypeUser(SignUp $typeUser): static
    {
        if (!$this->typeUser->contains($typeUser)) {
            $this->typeUser->add($typeUser);
            $typeUser->setType($this);
        }

        return $this;
    }

    public function removeTypeUser(SignUp $typeUser): static
    {
        if ($this->typeUser->removeElement($typeUser)) {
            // set the owning side to null (unless already changed)
            if ($typeUser->getType() === $this) {
                $typeUser->setType(null);
            }
        }

        return $this;
    }

    public function getT(): ?string
    {
        return $this->T;
    }

    public function setT(string $T): static
    {
        $this->T = $T;

        return $this;
    }
}
