<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Prediction::class, orphanRemoval: true)]
    private $prediction;

    public function __construct()
    {
        $this->prediction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Prediction>
     */
    public function getPrediction(): Collection
    {
        return $this->prediction;
    }

    public function addPrediction(Prediction $prediction): self
    {
        if (!$this->prediction->contains($prediction)) {
            $this->prediction[] = $prediction;
            $prediction->setLocation($this);
        }

        return $this;
    }

    public function removePrediction(Prediction $prediction): self
    {
        if ($this->prediction->removeElement($prediction)) {
            // set the owning side to null (unless already changed)
            if ($prediction->getLocation() === $this) {
                $prediction->setLocation(null);
            }
        }

        return $this;
    }
}
