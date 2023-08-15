<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Repository\RecipeRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\HasDescriptionTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ApiResource]
#[Post]
#[GetCollection]
#[Get(normalizationContext: ['groups' => ['Recipe:item:get']])]
#[Patch]
#[Delete]
class Recipe
{
    //Check HasIdTrait.php
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private ?bool $draft = true;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?int $break = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?int $preparation = null;

     /**
     * @var Collection<int, Step>
     */
    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Step::class, orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $steps;

     /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Image::class, orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $images;

    /**
     * @var Collection<int, RecipeHasSource>
     */
    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeHasSource::class, orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $recipeHasSources;

    /**
     * @var Collection<int, RecipeHasIngredient>
     */
    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeHasIngredient::class, orphanRemoval: true)]
    #[Groups(['Recipe:item:get'])]
    private Collection $recipeHasIngredients;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'recipes')]
    #[Groups(['Recipe:item:get'])]
    private Collection $tags;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $cooking = null;

    #[ORM\ManyToOne(inversedBy: 'Recipe')]
    private ?User $user = null;


    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->recipeHasSources = new ArrayCollection();
        $this->recipeHasIngredients = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /* // because we ue the extenssion stof_doctrine and now we have a trait that manage the timestamps 
    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null; */


    public function isDraft(): ?bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): static
    {
        $this->draft = $draft;

        return $this;
    }


    public function getBreak(): ?int
    {
        return $this->break;
    }

    public function setBreak(?int $break): static
    {
        $this->break = $break;

        return $this;
    }

    public function getPreparation(): ?int
    {
        return $this->preparation;
    }

    public function setPreparation(?int $preparation): static
    {
        $this->preparation = $preparation;

        return $this;
    }

    /*  // because we ue the extenssion stof_doctrine and now we have a trait that manage the timestamps 
    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    } */

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setRecipe($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRecipe() === $this) {
                $image->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeHasSource>
     */
    public function getRecipeHasSources(): Collection
    {
        return $this->recipeHasSources;
    }

    public function addRecipeHasSource(RecipeHasSource $recipeHasSource): static
    {
        if (!$this->recipeHasSources->contains($recipeHasSource)) {
            $this->recipeHasSources->add($recipeHasSource);
            $recipeHasSource->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeHasSource(RecipeHasSource $recipeHasSource): static
    {
        if ($this->recipeHasSources->removeElement($recipeHasSource)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasSource->getRecipe() === $this) {
                $recipeHasSource->setRecipe(null);
            }
        }

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
            $recipeHasIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeHasIngredient(RecipeHasIngredient $recipeHasIngredient): static
    {
        if ($this->recipeHasIngredients->removeElement($recipeHasIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasIngredient->getRecipe() === $this) {
                $recipeHasIngredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getCooking(): ?int
    {
        return $this->cooking;
    }

    public function setCooking(?int $cooking): static
    {
        $this->cooking = $cooking;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName().' ('.$this->getId().')';
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
