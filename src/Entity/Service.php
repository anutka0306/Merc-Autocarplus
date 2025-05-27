<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?float $base_price = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?ServiceCategory $category = null;

    /**
     * @var Collection<int, ModelServicePrice>
     */
    #[ORM\OneToMany(targetEntity: ModelServicePrice::class, mappedBy: 'service')]
    private Collection $modelServicePrices;

    public function __construct()
    {
        $this->modelServicePrices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getBasePrice(): ?float
    {
        return $this->base_price;
    }

    public function setBasePrice(?float $base_price): static
    {
        $this->base_price = $base_price;

        return $this;
    }

    public function getCategory(): ?ServiceCategory
    {
        return $this->category;
    }

    public function setCategory(?ServiceCategory $category): static
    {
        $this->category = $category;

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
            $modelServicePrice->setService($this);
        }

        return $this;
    }

    public function removeModelServicePrice(ModelServicePrice $modelServicePrice): static
    {
        if ($this->modelServicePrices->removeElement($modelServicePrice)) {
            // set the owning side to null (unless already changed)
            if ($modelServicePrice->getService() === $this) {
                $modelServicePrice->setService(null);
            }
        }

        return $this;
    }
}
