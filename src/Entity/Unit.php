<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Repository\UnitRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[Post]
#[GetCollection]
#[Get]
#[Patch]
#[Delete]
class Unit
{
    use HasIdTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private ?bool $singular = null;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private ?bool $plural = null;

    /**
     * @var Collection<int, RecipeHasIngredient>
     */
    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: RecipeHasIngredient::class)]
    private Collection $recipeHasIngredients;

    public function __construct()
    {
        $this->recipeHasIngredients = new ArrayCollection();
    }


    public function isSingular(): ?bool
    {
        return $this->singular;
    }

    public function setSingular(bool $singular): static
    {
        $this->singular = $singular;

        return $this;
    }

    public function isPlural(): ?bool
    {
        return $this->plural;
    }

    public function setPlural(bool $plural): static
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * @return Collection<int, RecipeHasIngredient>
     */
    public function getRecipeHasIngredients(): Collection
    {
        return $this->recipeHasIngredients;
    }

    public function addRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if (!$this->recipeHasIngredients->contains($recipeHasIngredient)) {
            $this->recipeHasIngredients->add($recipeHasIngredient);
            $recipeHasIngredient->setUnit($this);
        }

        return $this;
    }

    public function removeRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if ($this->recipeHasIngredients->removeElement($recipeHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasIngredient->getUnit() === $this) {
                $recipeHasIngredient->setUnit(null);
            }
        }

        return $this;
    }
}
