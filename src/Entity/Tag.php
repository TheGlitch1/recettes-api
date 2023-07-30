<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Repository\TagRepository;
use App\Entity\Traits\HasNameTrait;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\HasDescriptionTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource]
#[Post]
#[GetCollection]
#[Get]
#[Patch]
#[Delete]
class Tag
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;

    #[ORM\Column]
    #[Groups(['Recipe:item:get'])]
    private ?bool $menu = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[Groups(['Recipe:item:get'])]
    private ?self $parent = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    #[Groups(['Recipe:item:get'])]
    private Collection $children;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'tags')]
    private Collection $recipes;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->recipes = new ArrayCollection();
    }


    public function isMenu(): ?bool
    {
        return $this->menu;
    }

    public function setMenu(bool $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->addTag($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            $recipe->removeTag($this);
        }

        return $this;
    }
}
