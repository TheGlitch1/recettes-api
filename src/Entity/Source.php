<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Repository\SourceRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\HasTimestampTrait;
use App\Entity\Traits\HasDescriptionTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ApiResource]
#[Post]
#[GetCollection]
#[Get]
#[Patch]
#[Delete]
class Source
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use HasTimestampTrait;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?string $url = null;

    /**
     * @var Collection<int, RecipeHasSource>
     */
    #[ORM\OneToMany(mappedBy: 'source', targetEntity: RecipeHasSource::class, orphanRemoval: true)]
    private Collection $recipeHasSources;


    public function __construct()
    {
        $this->recipeHasSources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

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
            $recipeHasSource->setSource($this);
        }

        return $this;
    }

    public function removeRecipeHasSource(RecipeHasSource $recipeHasSource): static
    {
        if ($this->recipeHasSources->removeElement($recipeHasSource)) {
            // set the owning side to null (unless already changed)
            if ($recipeHasSource->getSource() === $this) {
                $recipeHasSource->setSource(null);
            }
        }

        return $this;
    }
}
