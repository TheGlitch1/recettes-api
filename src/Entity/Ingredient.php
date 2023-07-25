<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Repository\IngredientRepository;
use App\Entity\Traits\HasDescriptionTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{

    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use TimestampableEntity;

    #[ORM\Column]
    private ?bool $vegan = null;

    #[ORM\Column]
    private ?bool $vegetarian = null;

    #[ORM\Column]
    private ?bool $dairyFree = null;

    #[ORM\Column]
    private ?bool $glutenFree = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isVegan(): ?bool
    {
        return $this->vegan;
    }

    public function setVegan(bool $vegan): static
    {
        $this->vegan = $vegan;

        return $this;
    }

    public function isVegetarian(): ?bool
    {
        return $this->vegetarian;
    }

    public function setVegetarian(bool $vegetarian): static
    {
        $this->vegetarian = $vegetarian;

        return $this;
    }

    public function isDairyFree(): ?bool
    {
        return $this->dairyFree;
    }

    public function setDairyFree(bool $dairyFree): static
    {
        $this->dairyFree = $dairyFree;

        return $this;
    }

    public function isGlutenFree(): ?bool
    {
        return $this->glutenFree;
    }

    public function setGlutenFree(bool $glutenFree): static
    {
        $this->glutenFree = $glutenFree;

        return $this;
    }
}
