<?php

namespace App\Entity;

use App\Enums\InputFormat;
use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $api_url;

    #[ORM\Column(type: 'inputformat')]
    private $format;

    #[ORM\OneToMany(mappedBy: 'partner', targetEntity: Prediction::class, orphanRemoval: true)]
    private $predictions;

    public function __construct()
    {
        $this->predictions = new ArrayCollection();
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

    public function getApiUrl(): ?string
    {
        return $this->api_url;
    }

    public function setApiUrl(string $api_url): self
    {
        $this->api_url = $api_url;

        return $this;
    }

    public function getFormat(): ?InputFormat
    {
        return $this->format;
    }

    public function setFormat(InputFormat $format): self
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return Collection<int, Prediction>
     */
    public function getPredictions(): Collection
    {
        return $this->predictions;
    }

    public function addPrediction(Prediction $prediction): self
    {
        if (!$this->predictions->contains($prediction)) {
            $this->predictions[] = $prediction;
            $prediction->setPartner($this);
        }

        return $this;
    }

    public function removePrediction(Prediction $prediction): self
    {
        if ($this->predictions->removeElement($prediction)) {
            // set the owning side to null (unless already changed)
            if ($prediction->getPartner() === $this) {
                $prediction->setPartner(null);
            }
        }

        return $this;
    }
}
