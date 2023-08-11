<?php

namespace App\Entity;

use DateTime;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Repository\ImageRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\HasPriorityTrait;
use App\Entity\Traits\HasTimestampTrait;
use App\Entity\Traits\HasDescriptionTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(mercure: true)]
#[Post]
#[GetCollection]
#[Get]
#[Delete]
// #[Put]
// #[Patch]
#[Vich\Uploadable]
class Image
{

    use HasIdTrait;
    use HasDescriptionTrait;
    use HasPriorityTrait;
    use HasTimestampTrait;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['Recipe:item:get'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Recipe:item:get'])]
    private ?string $path = null;

    #[ORM\Column]
    private ?int $size = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'path', size: 'size')] //path and size are the new properties now for this 
    private ?File $imageFile = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Step $step = null;


    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getStep(): ?Step
    {
        return $this->step;
    }

    public function setStep(?Step $step): self
    {
        $this->step = $step;

        return $this;
    }


    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
 
    public function setImageFile(File|UploadedFile|null $imageFile = null): Image
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new DateTime());
        }

        return $this;
    }
}
