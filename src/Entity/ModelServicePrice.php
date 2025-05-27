<?php

namespace App\Entity;

use App\Repository\ModelServicePriceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelServicePriceRepository::class)]
class ModelServicePrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modelServicePrices')]
    private ?Model $model = null;

    #[ORM\ManyToOne(inversedBy: 'modelServicePrices')]
    private ?Service $service = null;

    #[ORM\Column]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
