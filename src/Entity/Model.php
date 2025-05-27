<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_ru = null;

    #[ORM\Column(length: 255)]
    private ?string $name_en = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'models')]
    private ?Brand $brand = null;

    /**
     * @var Collection<int, ModelServicePrice>
     */
    #[ORM\OneToMany(targetEntity: ModelServicePrice::class, mappedBy: 'model')]
    private Collection $modelServicePrices;


    public function __construct()
    {
        $this->modelServicePrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRu(): ?string
    {
        return $this->name_ru;
    }

    public function setNameRu(string $name_ru): static
    {
        $this->name_ru = $name_ru;

        return $this;
    }

    public function getNameEn(): ?string
    {
        return $this->name_en;
    }

    public function setNameEn(string $name_en): static
    {
        $this->name_en = $name_en;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, ModelServicePrice>
     */
    public function getModelServicePrices(): Collection
    {
        return $this->modelServicePrices;
    }

    public function addModelServicePrice(ModelServicePrice $modelServicePrice): static
    {
        if (!$this->modelServicePrices->contains($modelServicePrice)) {
            $this->modelServicePrices->add($modelServicePrice);
            $modelServicePrice->setModel($this);
        }

        return $this;
    }

    public function removeModelServicePrice(ModelServicePrice $modelServicePrice): static
    {
        if ($this->modelServicePrices->removeElement($modelServicePrice)) {
            // set the owning side to null (unless already changed)
            if ($modelServicePrice->getModel() === $this) {
                $modelServicePrice->setModel(null);
            }
        }

        return $this;
    }

}
