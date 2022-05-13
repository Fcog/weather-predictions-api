<?php

namespace App\Entity;

use App\ObjectValue\TempScale;
use App\Repository\PredictionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PredictionRepository::class)]
class Prediction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $time;

    #[ORM\Column(type: 'tempscale')]
    private $temperature;

    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'prediction')]
    #[ORM\JoinColumn(nullable: false)]
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTemperature(): ?TempScale
    {
        return $this->temperature;
    }

    public function setTemperature(TempScale $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
